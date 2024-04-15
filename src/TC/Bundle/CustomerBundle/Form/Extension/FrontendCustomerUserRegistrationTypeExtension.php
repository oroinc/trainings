<?php

namespace TC\Bundle\CustomerBundle\Form\Extension;

use Oro\Bundle\CustomerBundle\Entity\CustomerUser;
use Oro\Bundle\CustomerBundle\Form\Type\FrontendCustomerUserRegistrationType;
use Oro\Bundle\CustomerBundle\Form\Type\FrontendCustomerUserTypedAddressType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class FrontendCustomerUserRegistrationTypeExtension extends AbstractTypeExtension
{
    protected FormBuilderInterface $builder;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->builder = $builder;
        $this->addBillingAddressField();
    }

    protected function addBillingAddressField(): void
    {
        $this->builder->add(
            'billingAddress',
            FrontendCustomerUserTypedAddressType::class,
            [
                'label' => 'tc.customer.registration.address.label',
                'property_path' => 'addresses[0]',
                'all_addresses_property_path' => false,
                'priority' => -1
            ]
        );

        $this->builder->addEventListener(
            FormEvents::SUBMIT,
            function(FormEvent $event) {
                $cu = $event->getData();

                if ($cu instanceof CustomerUser && $cu->getAddresses()->first()) {
                    $cu->getAddresses()->first()->setFrontendOwner($cu);
                }
            }
        );

    }

    public static function getExtendedTypes(): iterable
    {
        return [
            FrontendCustomerUserRegistrationType::class
        ];
    }
}
