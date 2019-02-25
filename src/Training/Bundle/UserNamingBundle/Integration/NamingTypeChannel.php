<?php

namespace Training\Bundle\UserNamingBundle\Integration;

use Oro\Bundle\IntegrationBundle\Provider\ChannelInterface;
use Oro\Bundle\IntegrationBundle\Provider\IconAwareIntegrationInterface;

class NamingTypeChannel implements ChannelInterface, IconAwareIntegrationInterface
{
    const TYPE = 'naming_type';

    /**
     * {@inheritDoc}
     */
    public function getLabel()
    {
        return 'training.usernaming.integration.label';
    }

    /**
     * {@inheritDoc}
     */
    public function getIcon()
    {
        return 'bundles/trainingusernaming/img/naming-integration-icon.png';
    }
}
