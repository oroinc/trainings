<?php

namespace Training\Bundle\MessageQueueBundle\EventListener;

use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Oro\Component\MessageQueue\Client\MessageProducerInterface;
use Training\Bundle\MessageQueueBundle\Async\Topics\GenerateNameExampleTopic;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

class NamingFormatModificationListener
{
    public function __construct(private MessageProducerInterface $messageProducer)
    {
    }

    /**
     * @param UserNamingType $namingType
     * @param PostPersistEventArgs $event
     */
    public function postPersist(UserNamingType $namingType, PostPersistEventArgs $event)
    {
        $this->sendNameExampleGenerationMessage($namingType);
    }

    /**
     * @param UserNamingType $namingType
     * @param PreUpdateEventArgs $event
     */
    public function preUpdate(UserNamingType $namingType, PreUpdateEventArgs $event)
    {
        if ($event->hasChangedField('format')) {
            $this->sendNameExampleGenerationMessage($namingType);
        }
    }

    /**
     * @param UserNamingType $namingType
     */
    protected function sendNameExampleGenerationMessage(UserNamingType $namingType)
    {
        $this->messageProducer->send(GenerateNameExampleTopic::getName(), ['id' => $namingType->getId()]);
    }
}
