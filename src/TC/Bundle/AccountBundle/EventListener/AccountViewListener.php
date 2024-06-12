<?php

namespace TC\Bundle\AccountBundle\EventListener;

use Oro\Bundle\UIBundle\Event\BeforeListRenderEvent;
use Oro\Bundle\AccountBundle\Entity\Account;
use Symfony\Contracts\Translation\TranslatorInterface;
use TC\Bundle\AccountBundle\Helper\CustomerFinder;

class AccountViewListener
{
    public function __construct(
        private CustomerFinder $customerFinder,
        private TranslatorInterface $translator
    ) {
    }

    public function onView(BeforeListRenderEvent $event): void
    {
        /** @var Account $account */
        $account = $event->getEntity();
        if (!$account) {
            return;
        }

        $customers = $this->customerFinder->getRelatedToAccount($account);
        $template = $event->getEnvironment()->render(
            '@TCAccount/Account/customersAddresses.html.twig',
            ['customers' => $customers]
        );

        $blockId = $event->getScrollData()->addBlock(
            $this->translator->trans('tc.account.block.addresses'),
            1
        );
        $subBlockId = $event->getScrollData()->addSubBlock($blockId);

        $event->getScrollData()->addSubBlockData($blockId, $subBlockId, $template);
    }
}
