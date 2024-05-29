<?php

namespace TC\Bundle\UserBundle\Async;

use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Oro\Bundle\UserBundle\Entity\User;
use Oro\Component\MessageQueue\Client\TopicSubscriberInterface;
use Oro\Component\MessageQueue\Consumption\MessageProcessorInterface;
use Oro\Component\MessageQueue\Transport\MessageInterface;
use Oro\Component\MessageQueue\Transport\SessionInterface;
use TC\Bundle\UserBundle\Async\Topics\GenerateUserFullNameExtendedTopic;
use TC\Bundle\UserBundle\Helper\UserNameHelper;

class UserFullNameExtendedProcessor implements MessageProcessorInterface, TopicSubscriberInterface
{
    public function __construct(private DoctrineHelper $doctrineHelper, private UserNameHelper $nameHelper)
    {
    }

    public function process(MessageInterface $message, SessionInterface $session)
    {
        $body = $message->getBody();

        $user = $this->doctrineHelper->getEntity(User::class, $body['id']);
        if ($user) {
            $user->setFullNameExtended($this->nameHelper->getFullNameExtended($user));
            $this->doctrineHelper->getEntityManager(User::class)->flush();
        }

        return self::ACK;
    }

    public static function getSubscribedTopics(): array
    {
        return [GenerateUserFullNameExtendedTopic::getName()];
    }
}
