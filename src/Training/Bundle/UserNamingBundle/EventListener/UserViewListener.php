<?php

namespace Training\Bundle\UserNamingBundle\EventListener;

use Oro\Bundle\UIBundle\Event\BeforeListRenderEvent;
use Oro\Bundle\UserBundle\Entity\User;

/**
 * This class listen to BeforeListRenderEvent and some blocks
 */
class UserViewListener
{
    /**
     * Adds sub-block to user profile page in admin panel
     *
     * @param BeforeListRenderEvent $event
     *
     * @return void
     */
    public function onUserView(BeforeListRenderEvent $event): void
    {
        if (!$event->getEntity() instanceof User) {
            return;
        }

        $event->getScrollData()->addSubBlockData(0, 0, $this->getTemplate($event));
    }

    private function getTemplate(BeforeListRenderEvent $event): string
    {
        return $event->getEnvironment()->render(
            '@TrainingUserNaming/User/custom_user_block.html.twig',
            ['user' => $event->getEntity()]
        );
    }
}
