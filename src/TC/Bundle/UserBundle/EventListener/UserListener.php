<?php

namespace TC\Bundle\UserBundle\EventListener;

use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Oro\Bundle\UserBundle\Entity\User;
use Oro\Component\MessageQueue\Client\MessageProducerInterface;
use TC\Bundle\UserBundle\Async\Topics\GenerateUserFullNameExtendedTopic;

class UserListener
{
    public function __construct(private MessageProducerInterface $messageProducer)
    {
    }

    public function postPersist(User $user, PostPersistEventArgs $event)
    {
        $this->sendGenerateFullNameExtMessage($user);
    }

    public function preUpdate(User $user, PreUpdateEventArgs $event)
    {
        if ($event->hasChangedField('namePrefix') || $event->hasChangedField('firstName')
            || $event->hasChangedField('lastName') || $event->hasChangedField('middleName')
            || $event->hasChangedField('nameSuffix')) {
            $this->sendGenerateFullNameExtMessage($user);
        }
    }

    protected function sendGenerateFullNameExtMessage(User $user)
    {
        $this->messageProducer->send(GenerateUserFullNameExtendedTopic::getName(), ['id' => $user->getId()]);
    }
}
