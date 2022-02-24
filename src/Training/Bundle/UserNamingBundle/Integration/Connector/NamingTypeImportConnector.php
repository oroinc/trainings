<?php

namespace Training\Bundle\UserNamingBundle\Integration\Connector;

use Oro\Bundle\IntegrationBundle\Provider\AbstractConnector;

class NamingTypeImportConnector extends AbstractConnector
{
    const IMPORT_ENTITY = 'Training\Bundle\UserNamingBundle\Entity\UserNamingType';
    const IMPORT_JOB = 'training_user_naming_type_import';
    const TYPE = 'user_naming_type';

    /**
     * {@inheritdoc}
     */
    protected function getConnectorSource()
    {
        return $this->transport->getNamingTypes();
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel(): string
    {
        return 'training.usernaming.integration.connector.user_naming_type.label';
    }

    /**
     * {@inheritdoc}
     */
    public function getImportEntityFQCN()
    {
        return self::IMPORT_ENTITY;
    }

    /**
     * {@inheritdoc}
     */
    public function getImportJobName()
    {
        return self::IMPORT_JOB;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE;
    }
}
