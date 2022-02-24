<?php

namespace Training\Bundle\UserNamingBundle\Integration;

use Oro\Bundle\IntegrationBundle\Entity\Transport;
use Oro\Bundle\IntegrationBundle\Provider\TransportInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Training\Bundle\UserNamingBundle\Entity\UserNamingIntegrationSettings;
use Training\Bundle\UserNamingBundle\Form\Type\NamingTypeIntegrationSettingsType;

class NamingTypeTransport implements TransportInterface
{
    private ParameterBag $settings;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(private LoggerInterface $logger)
    {
    }

    /**
     * @param Transport $transportEntity
     */
    public function init(Transport $transportEntity)
    {
        $this->settings = $transportEntity->getSettingsBag();
    }

    /**
     * {@inheritdoc}
     */
    public function getSettingsFormType(): string
    {
        return NamingTypeIntegrationSettingsType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getSettingsEntityFQCN(): string
    {
        return UserNamingIntegrationSettings::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel(): string
    {
        return 'training.usernaming.integration.settings.label';
    }

    /**
     * @return \ArrayIterator
     */
    public function getNamingTypes(): \ArrayIterator
    {
        $url = $this->settings->get(UserNamingIntegrationSettings::DATA_URL);

        $data = file_get_contents($url);
        if (!$data) {
            $this->logger->warning('Can\'t get user naming types from URL', ['url' => $url]);
            return new \ArrayIterator([]);;
        }

        $jsonData = json_decode($data, true);
        if (!$jsonData) {
            $this->logger->notice('No naming types received from URL', ['url' => $url]);
            return new \ArrayIterator([]);
        }

        return new \ArrayIterator($jsonData);
    }
}
