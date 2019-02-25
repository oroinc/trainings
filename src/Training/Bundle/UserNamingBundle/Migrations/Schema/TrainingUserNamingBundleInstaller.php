<?php

namespace Training\Bundle\UserNamingBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;

use Oro\Bundle\EntityExtendBundle\EntityConfig\ExtendScope;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtension;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtensionAwareInterface;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class TrainingUserNamingBundleInstaller implements Installation, ExtendExtensionAwareInterface
{
    /** @var ExtendExtension */
    private $extendExtension;

    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion()
    {
        return 'v1_2';
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        /** Tables generation **/
        $this->createTrainingUserNamingTypeTable($schema);

        /** Update integration table */
        $this->updateIntegrationTable($schema);

        /** Additional relations */
        $this->addRelationFromUser($schema);
    }

    /**
     * Create training_user_naming_type table
     *
     * @param Schema $schema
     */
    protected function createTrainingUserNamingTypeTable(Schema $schema)
    {
        $table = $schema->createTable('training_user_naming_type');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('title', 'string', ['length' => 64]);
        $table->addColumn('format', 'string', ['length' => 255]);
        $table->setPrimaryKey(['id']);
    }

    /**
     * Add required fields to integration table
     *
     * @param Schema $schema
     */
    protected function updateIntegrationTable(Schema $schema)
    {
        $table = $schema->getTable('oro_integration_transport');
        $table->addColumn('user_naming_url', 'string', ['notnull' => false, 'length' => 255]);
    }

    /**
     * Add relation from User entity to UserNamingType entity
     *
     * @param Schema $schema
     */
    protected function addRelationFromUser(Schema $schema)
    {
        $this->extendExtension->addManyToOneRelation(
            $schema,
            'oro_user',
            'namingType',
            'training_user_naming_type',
            'title',
            [
                'extend' => ['owner' => ExtendScope::OWNER_CUSTOM],
            ]
        );
    }

    /**
     * @param ExtendExtension $extendExtension
     */
    public function setExtendExtension(ExtendExtension $extendExtension)
    {
        $this->extendExtension = $extendExtension;
    }
}
