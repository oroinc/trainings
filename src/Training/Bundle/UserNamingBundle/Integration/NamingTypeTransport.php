<?php

namespace Training\Bundle\UserNamingBundle\Integration;

use Oro\Bundle\IntegrationBundle\Entity\Transport;
use Oro\Bundle\IntegrationBundle\Provider\TransportInterface;
use Training\Bundle\UserNamingBundle\Entity\UserNamingIntegrationSettings;
use Training\Bundle\UserNamingBundle\Form\Type\NamingTypeIntegrationSettingsType;

class NamingTypeTransport implements TransportInterface
{
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
}
