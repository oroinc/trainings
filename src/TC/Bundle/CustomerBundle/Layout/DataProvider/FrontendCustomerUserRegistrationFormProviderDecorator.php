<?php

namespace TC\Bundle\CustomerBundle\Layout\DataProvider;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Oro\Bundle\AddressBundle\Entity\AddressType;
use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Oro\Bundle\CustomerBundle\Entity\CustomerUserAddress;
use Oro\Bundle\CustomerBundle\Layout\DataProvider\FrontendCustomerUserRegistrationFormProvider as BaseProvider;
use Oro\Bundle\WebsiteBundle\Manager\WebsiteManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FrontendCustomerUserRegistrationFormProviderDecorator extends BaseProvider
{
    public function __construct(
        FormFactoryInterface $formFactory,
        ConfigManager $configManager,
        WebsiteManager $websiteManager,
        ManagerRegistry $doctrine,
        UrlGeneratorInterface $router
    ) {
        parent::__construct($formFactory, $configManager, $websiteManager, $doctrine, $router);
    }

    public function createCustomerUser()
    {
        $customerUser = parent::createCustomerUser();
        $customerUser->addAddress($this->createBaseAddress($customerUser));

        return $customerUser;
    }

    protected function createBaseAddress($customerUser)
    {
        $address = new CustomerUserAddress();
        $address->setPrimary(true);

        $typeShipping = new AddressType(AddressType::TYPE_SHIPPING);
        $typeBilling = new AddressType(AddressType::TYPE_BILLING);
        $address->setTypes(new ArrayCollection([$typeShipping, $typeBilling]));
        $address->setDefaults(new ArrayCollection([$typeShipping, $typeBilling]));

        return $address;
    }
}
