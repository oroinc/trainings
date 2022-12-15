<?php

namespace Training\Bundle\UserNamingBundle\EventListener;

use Oro\Bundle\UIBundle\Event\BeforeListRenderEvent;
use Oro\Bundle\UserBundle\Entity\User;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
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

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    private function getTemplate(BeforeListRenderEvent $event): string
    {
        return $event->getEnvironment()->render(
            '@TrainingUserNaming/User/custom_user_block.html.twig',
            ['user' => $event->getEntity()]
        );
    }
}
