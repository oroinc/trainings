<?php

namespace Training\Bundle\CrmBundle\EventListener;

use Oro\Bundle\CallBundle\Entity\Call;
use Oro\Bundle\CallBundle\Form\Type\CallType;
use Oro\Bundle\SalesBundle\Entity\Lead;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class LeadCallActivityFormExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($builder->has('contexts')) {
            $builder->addEventListener(FormEvents::POST_SET_DATA, [$this, 'addAccountContext']);
        }
    }

    /**
     * @param FormEvent $event
     */
    public function addAccountContext(FormEvent $event): void
    {
        /** @var Call $entity */
        $entity = $event->getData();
        $form = $event->getForm();

        // only for new call logs
        if (!is_object($entity) || $entity->getId()) {
            return;
        }

        $contexts = $form->get('contexts')->getData();

        foreach ($contexts as $targetEntity) {
            if (!$targetEntity instanceof Lead) {
                continue;
            }

            $customer = $targetEntity->getCustomerAssociation();
            if ($customer === null) {
                continue;
            }

            $form->get('contexts')->setData(array_merge($contexts, [$customer->getAccount()]));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return CallType::class;
    }
}
