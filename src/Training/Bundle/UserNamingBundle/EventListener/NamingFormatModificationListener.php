<?php

namespace Training\Bundle\UserNamingBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Oro\Component\MessageQueue\Client\MessageProducerInterface;
use Training\Bundle\UserNamingBundle\Async\Topics;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

class NamingFormatModificationListener
{
    /** @var MessageProducerInterface */
    private $messageProducer;

    /**
     * @param MessageProducerInterface $messageProducer
     */
    public function __construct(MessageProducerInterface $messageProducer)
    {
        $this->messageProducer = $messageProducer;
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
        $this->messageProducer->send(Topics::GENERATE_NAME_EXAMPLE, ['id' => $namingType->getId()]);
    }
}
