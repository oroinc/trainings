<?php

namespace TC\Bundle\AccountBundle\EventListener;

use Oro\Bundle\UIBundle\Event\BeforeListRenderEvent;
use Oro\Bundle\AccountBundle\Entity\Account;
use TC\Bundle\AccountBundle\Helper\CustomerFinder;

class AccountViewListener
{
    public function __construct(
        private CustomerFinder $customerFinder
    ) {
    }

    public function onView(BeforeListRenderEvent $event)
    {
        /** @var Account $account */
        $account = $event->getEntity();
        if (!$account) {
            return;
        }

        $customers = $this->customerFinder->getRelatedToAccounts([$account]);
        $template = $event->getEnvironment()->render(
            '@TCAccount/Account/customersAddresses.html.twig',
            ['customers' => $customers]
        );

        $blockId = $event->getScrollData()->addBlock('Addresses', 1);
        $subblockId = $event->getScrollData()->addSubBlock($blockId);

        $event->getScrollData()->addSubBlockData($blockId, $subblockId, $template);
    }
}
