<?php

namespace Training\Bundle\IntegrationBundle\Integration;

use Oro\Bundle\IntegrationBundle\Provider\ChannelInterface;
use Oro\Bundle\IntegrationBundle\Provider\IconAwareIntegrationInterface;

class NamingTypeChannel implements ChannelInterface, IconAwareIntegrationInterface
{
    const TYPE = 'naming_type';

    /**
     * {@inheritDoc}
     */
    public function getLabel(): string
    {
        return 'training.integration.label';
    }

    /**
     * {@inheritDoc}
     */
    public function getIcon(): string
    {
        return 'bundles/trainingintegration/img/naming-integration-icon.png';
    }
}
