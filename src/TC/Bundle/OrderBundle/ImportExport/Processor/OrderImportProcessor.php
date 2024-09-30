<?php

namespace TC\Bundle\OrderBundle\ImportExport\Processor;

use Doctrine\Persistence\ManagerRegistry;
use Oro\Bundle\AddressBundle\Entity\Country;
use Oro\Bundle\AddressBundle\Entity\Region;
use Oro\Bundle\CurrencyBundle\Entity\Price;
use Oro\Bundle\CustomerBundle\Entity\Customer;
use Oro\Bundle\CustomerBundle\Entity\CustomerUser;
use Oro\Bundle\EntityExtendBundle\Entity\AbstractEnumValue;
use Oro\Bundle\ImportExportBundle\Processor\ImportProcessor;
use Oro\Bundle\ImportExportBundle\Strategy\Import\ImportStrategyHelper;
use Oro\Bundle\OrderBundle\Entity\Order;
use Oro\Bundle\OrderBundle\Entity\OrderAddress;
use Oro\Bundle\OrderBundle\Entity\OrderLineItem;
use Oro\Bundle\OrderBundle\Total\TotalHelper;
use Oro\Bundle\ProductBundle\Entity\Product;
use Oro\Bundle\ProductBundle\Entity\ProductUnit;
use Oro\Bundle\WebsiteBundle\Entity\Website;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class OrderImportProcessor extends ImportProcessor
{
    private const ADDRESS_TYPE_BILLING = 'Billing';
    private const ADDRESS_TYPE_SHIPPING = 'Shipping';
    private const ADDRESS_FIELDS = [
        'Label' => 'setLabel',
        'Organization' => 'setOrganization',
        'Name prefix' => 'setNamePrefix',
        'First name' => 'setFirstName',
        'Middle name' => 'setMiddleName',
        'Last name' => 'setLastName',
        'Name suffix' => 'setNameSuffix',
        'Street' => 'setStreet',
        'Street 2' => 'setStreet2',
        'Zip/Postal Code' => 'setPostalCode',
        'City' => 'setCity',
        'Phone' => 'setPhone',
        'Country ISO2 code' => null,
        'State code' => null
    ];

    private ManagerRegistry $doctrine;
    private TotalHelper $totalHelper;
    private ImportStrategyHelper $importStrategyHelper;
    private ValidatorInterface $validator;
    private TranslatorInterface $translator;
    private LoggerInterface $logger;

    private array $item = [];
    private array $locationTypes = [];
    private ?AbstractEnumValue $defaultLocationType = null;

    public function __construct(
        ManagerRegistry $doctrine,
        TotalHelper $totalHelper,
        ImportStrategyHelper $importStrategyHelper,
        ValidatorInterface $validator,
        TranslatorInterface $translator,
        LoggerInterface $logger
    ) {
        $this->doctrine = $doctrine;
        $this->totalHelper = $totalHelper;
        $this->importStrategyHelper = $importStrategyHelper;
        $this->validator = $validator;
        $this->translator = $translator;
        $this->logger = $logger;
    }

    public function process($item)
    {
        $this->item = $item;

        try {
            $website = $this->doctrine->getRepository(Website::class)->findOneByName($item['Website']);
            $customer = $this->doctrine->getRepository(Customer::class)->findOneByName($item['Customer']);
            $customerUser = $this->doctrine->getRepository(CustomerUser::class)
                ->findUserByEmail($item['Customer User']);

            $order = new Order();
            $order
                ->setWebsite($website)
                ->setCustomer($customer)
                ->setCustomerUser($customerUser)
                ->setIdentifier($item['Identifier'])
                ->setCurrency($item['Currency'])
                ->setPoNumber($item['PO Number'])
                ->setShipUntil(new \DateTime($item['Ship Until']))
                ->setCustomerNotes($item['Customer Notes'])
            ;

            $this->addAddress($order, self::ADDRESS_TYPE_BILLING);
            $this->addAddress($order, self::ADDRESS_TYPE_SHIPPING);

            $this->addLineItems($order);

            $this->totalHelper->fill($order);
        } catch (\Throwable $exception) {
            $this->logger->error('Error occurred during Order import. Order identifier: ' . $item['Identifier'], [
                'error' => $exception->getMessage(),
                'exception' => $exception,
            ]);

            $this->addError(
                'tc.order.import.exception',
                [
                    '%identifier%' => $item['Identifier']
                ]
            );

            return null;
        }

        if (false === $this->isValid($order)) {
            return null;
        }

        $this->context->incrementAddCount();

        return $order;
    }

    private function addAddress(Order $order, string $addressType): void
    {
        $allFieldsEmpty = true;

        foreach (array_keys(self::ADDRESS_FIELDS) as $addressFieldName) {
            if (!empty($this->getAddressFieldVal($addressFieldName, $addressType))) {
                $allFieldsEmpty = false;
                break;
            }
        }

        if ($allFieldsEmpty) {
            return;
        }

        $address = new OrderAddress();

        foreach (self::ADDRESS_FIELDS as $addressFieldName => $setter) {
            if (!empty($setter) && method_exists($address, $setter)) {
                $address->$setter($this->getAddressFieldVal($addressFieldName, $addressType));
            }
        }

        $country = $this->doctrine->getRepository(Country::class)
            ->findOneBy(['iso2Code' => $this->getAddressFieldVal('Country ISO2 code', $addressType)]);
        $region = $this->doctrine->getRepository(Region::class)
            ->findOneBy([
                'combinedCode' => sprintf(
                    '%s-%s',
                    $this->getAddressFieldVal('Country ISO2 code', $addressType),
                    $this->getAddressFieldVal('State code', $addressType)
                )
            ]);

        if ($country) {
            $address->setCountry($country);
        }
        if ($region) {
            $address->setRegion($region);
        }

        switch ($addressType) {
            case self::ADDRESS_TYPE_BILLING:
                $order->setBillingAddress($address);
                break;
            case self::ADDRESS_TYPE_SHIPPING:
                $order->setShippingAddress($address);
                break;
        }
    }

    private function getAddressFieldVal(string $name, string $addressType): ?string
    {
        return $this->item[sprintf(
            '%s Address %s',
            $addressType,
            $name
        )];
    }

    private function addLineItems(Order $order): void
    {
        $lineItemsData = $this->getLineItemsData();

        foreach ($lineItemsData as $lineItemData) {
            $allFieldsEmpty = true;

            foreach ($lineItemData as $lineItemValue) {
                if (!empty($lineItemValue)) {
                    $allFieldsEmpty = false;
                    break;
                }
            }

            if ($allFieldsEmpty) {
                continue;
            }

            $existingProduct = $this->doctrine->getRepository(Product::class)
                ->findOneBySku($lineItemData['Sku']);

            $productUnit = $this->doctrine->getRepository(ProductUnit::class)
                ->findOneBy(['code' => $lineItemData['Unit']]);

            $price = new Price();
            $price->setValue($lineItemData['Price'])->setCurrency($this->item['Currency']);

            $lineItem = new OrderLineItem();

            if ($existingProduct) {
                $lineItem->setProduct($existingProduct);
            } else {
                $lineItem->setProductSku($lineItemData['Sku']);
                $lineItem->setFreeFormProduct($lineItemData['Product name'] ?: $lineItemData['Sku']);
            }

            $lineItem
                ->setQuantity((float)$lineItemData['Quantity'])
                ->setProductUnit($productUnit)
                ->setPrice($price)
            ;

            $order->addLineItem($lineItem);
        }
    }

    /**
     * @return array
     *     [
     *         lineItemNumber => [
     *             lineItemFieldName => itemValue,
     *             ...
     *         ],
     *         ...
     *     ]
     */
    private function getLineItemsData(): array
    {
        $lineItemsData = [];
        foreach ($this->item as $itemKey => $itemValue) {
            $pattern = '/Line Item (\d+) (.+)/';
            if (preg_match($pattern, $itemKey, $matches)) {
                $lineItemNumber = (int)$matches[1];
                $lineItemFieldName = $matches[2];

                $lineItemsData[$lineItemNumber][$lineItemFieldName] = $itemValue;
            }
        }

        return $lineItemsData;
    }

    private function isValid(Order $order): bool
    {
        $errors = $this->validator->validate($order);

        if ($order->getBillingAddress()) {
            $errors->addAll($this->validator->validate($order->getBillingAddress()));
        }
        if ($order->getShippingAddress()) {
            $errors->addAll($this->validator->validate($order->getShippingAddress()));
        }

        if ($errors->count()) {
            $messages = [];

            /** @var ConstraintViolationInterface $error */
            foreach ($errors as $error) {
                $messages[] = sprintf(
                    '%s => %s',
                    $error->getPropertyPath(),
                    $error->getMessage()
                );
            }

            $this->addError(
                'tc.order.import.validation_errors',
                [
                    '%identifier%' => $order->getIdentifier(),
                    '%messages%' => implode('; ', $messages),
                ]
            );

            return false;
        }

        return true;
    }

    private function addError(string $error, array $parameters = []): void
    {
        $this->context->incrementErrorEntriesCount();

        $this->importStrategyHelper->addValidationErrors(
            [$this->translator->trans($error, $parameters, 'validators')],
            $this->context
        );
    }
}
