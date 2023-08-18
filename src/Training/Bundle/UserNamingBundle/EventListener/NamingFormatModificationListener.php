<?php

namespace Training\Bundle\UserNamingBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Oro\Component\MessageQueue\Client\MessageProducerInterface;
use Training\Bundle\UserNamingBundle\Async\Topics\GenerateNameExampleTopic;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

class NamingFormatModificationListener
{
    /**
     * @param MessageProducerInterface $messageProducer
     */
    public function __construct(private MessageProducerInterface $messageProducer)
    {
    }

    /**
     * @param UserNamingType $namingType
     * @param LifecycleEventArgs $event
     */
    public function postPersist(UserNamingType $namingType, LifecycleEventArgs $event)
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
