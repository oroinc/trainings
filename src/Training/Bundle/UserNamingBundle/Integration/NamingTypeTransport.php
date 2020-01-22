<?php

namespace Training\Bundle\UserNamingBundle\Integration;

use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Oro\Bundle\IntegrationBundle\Entity\Transport;
use Oro\Bundle\IntegrationBundle\Provider\TransportInterface;
use Psr\Log\LoggerInterface;
use Training\Bundle\UserNamingBundle\Entity\Repository\UserNamingIntegrationSettingsRepository;
use Training\Bundle\UserNamingBundle\Entity\UserNamingIntegrationSettings;
use Training\Bundle\UserNamingBundle\Form\Type\NamingTypeIntegrationSettingsType;

class NamingTypeTransport implements TransportInterface
{
    /** @var DoctrineHelper */
    private $doctrineHelper;

    /** @var LoggerInterface  */
    private $logger;

    /**
     * @param DoctrineHelper $doctrineHelper
     * @param LoggerInterface $logger
     */
    public function __construct(DoctrineHelper $doctrineHelper, LoggerInterface $logger)
    {
        $this->doctrineHelper = $doctrineHelper;
        $this->logger = $logger;
    }

    /**
     * @param Transport $transportEntity
     */
    public function init(Transport $transportEntity)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getSettingsFormType()
    {
        return NamingTypeIntegrationSettingsType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getSettingsEntityFQCN()
    {
        return UserNamingIntegrationSettings::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'training.usernaming.integration.settings.label';
    }

    /**
     * @param integer $channelId
     * @return array
     */
    public function getNamingTypeData($channelId)
    {
        /** @var UserNamingIntegrationSettingsRepository $settingsRepository */
        $settingsRepository = $this->doctrineHelper->getEntityRepository(UserNamingIntegrationSettings::class);

        $channels = $settingsRepository->findByEnabledChannel($channelId);
        if (empty($channels)) {
            $this->logger->warning('Channel not found', ['id' => $channelId]);
            return [];
        }

        /** @var UserNamingIntegrationSettings $channel */
        $channel = reset($channels);

        $url = $channel->getUrl();
        $data = file_get_contents($url);
        if (!$data) {
            $this->logger->warning('Can\'t get user naming types from URL', ['url' => $url]);
            return [];
        }

        $jsonData = json_decode($data, true);
        if (!$jsonData) {
            $this->logger->notice('No naming types received from URL', ['url' => $url]);
            return [];
        }

        return $jsonData;
    }
}
