<?php

namespace TC\Bundle\UserBundle\EventListener;

use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Oro\Bundle\UserBundle\Entity\User;
use Oro\Component\MessageQueue\Client\MessageProducerInterface;
use TC\Bundle\UserBundle\Async\Topics\GenerateUserFullNameExtendedTopic;

class UserListener
{
    public const FIELDS_TO_MONITOR = [
        'namePrefix',
        'firstName',
        'middleName',
        'lastName',
        'nameSuffix',
    ];

    public function __construct(private MessageProducerInterface $messageProducer)
    {
    }

    public function postPersist(User $user, PostPersistEventArgs $event)
    {
        $this->sendGenerateFullNameExtMessage($user);
    }

    public function preUpdate(User $user, PreUpdateEventArgs $event)
    {
        foreach (self::FIELDS_TO_MONITOR as $field) {
            if ($event->hasChangedField($field)) {
                $this->sendGenerateFullNameExtMessage($user);
                break;
            }
        }
    }

    protected function sendGenerateFullNameExtMessage(User $user)
    {
        $this->messageProducer->send(GenerateUserFullNameExtendedTopic::getName(), ['id' => $user->getId()]);
    }
}
