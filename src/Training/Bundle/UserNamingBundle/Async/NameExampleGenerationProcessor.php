<?php

namespace Training\Bundle\UserNamingBundle\Async;

use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Oro\Component\MessageQueue\Client\TopicSubscriberInterface;
use Oro\Component\MessageQueue\Consumption\MessageProcessorInterface;
use Oro\Component\MessageQueue\Transport\MessageInterface;
use Oro\Component\MessageQueue\Transport\SessionInterface;
use Training\Bundle\UserNamingBundle\Async\Topics\GenerateNameExampleTopic;
use Training\Bundle\UserNamingBundle\Provider\UserFullNameProvider;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

class NameExampleGenerationProcessor implements MessageProcessorInterface, TopicSubscriberInterface
{
    /**
     * @param DoctrineHelper $doctrineHelper
     * @param UserFullNameProvider $nameProvider
     */
    public function __construct(private DoctrineHelper $doctrineHelper, private UserFullNameProvider $nameProvider)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function process(MessageInterface $message, SessionInterface $session)
    {
        $body = $message->getBody();

        /** @var UserNamingType|null $namingType */
        $namingType = $this->doctrineHelper->getEntity(UserNamingType::class, $body['id']);
        if ($namingType) {
            $namingType->setExample($this->nameProvider->getFullNameExample($namingType->getFormat()));
            $this->doctrineHelper->getEntityManager(UserNamingType::class)
                ->flush();
        }

        return self::ACK;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedTopics(): array
    {
        return [GenerateNameExampleTopic::getName()];
    }
}
