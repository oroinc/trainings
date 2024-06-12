<?php

namespace Acme\Bundle\OrderBundle\EventListener;

use Oro\Bundle\OrderBundle\Entity\Order;
use Oro\Bundle\UIBundle\Event\BeforeListRenderEvent;
use Symfony\Contracts\Translation\TranslatorInterface;

class OrderViewEventListener
{

    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function onView(BeforeListRenderEvent $event)
    {
        /** @var Order $order */
        $order = $event->getEntity();
        if (!$order instanceof Order) {
            return;
        }

        $html = $event->getEnvironment()->render(
            '@AcmeOrder/Order/orderAdditionalInfo.html.twig',
            ['order' => $order]
        );

        $event->getScrollData()->addNamedBlock(
            'order_additional_information',
            $this->translator->trans('acme.order.additional_information.label'),
            -170
        );
        $event->getScrollData()->addSubBlock('order_additional_information');
        $event->getScrollData()->addSubBlockData('order_additional_information', 0, $html);
    }
}
