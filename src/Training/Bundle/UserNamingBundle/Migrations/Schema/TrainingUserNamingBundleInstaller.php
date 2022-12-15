<?php

namespace Training\Bundle\UserNamingBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Oro\Bundle\EntityExtendBundle\EntityConfig\ExtendScope;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtension;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtensionAwareInterface;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class TrainingUserNamingBundleInstaller implements Installation, ExtendExtensionAwareInterface
{
    private ExtendExtension $extendExtension;

    public function getMigrationVersion(): string
    {
        return 'v1_1';
    }

    public function up(Schema $schema, QueryBag $queries)
    {
        $table = $schema->createTable('training_user_naming_type');

        $this->createUserNamingTypeFields($table);

        $this->addRelationToUser($table, $schema);
    }

    private function createUserNamingTypeFields(Table $table)
    {
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('title', 'string', ['length' => 64]);
        $table->addColumn('format', 'string', ['length' => 255]);

        $table->setPrimaryKey(['id']);
    }

    private function addRelationToUser(Table $table, Schema $schema)
    {
        $this->extendExtension->addManyToOneRelation(
            $schema,
            'oro_user',
            'namingType',
            $table,
            'title',
            [
                'extend' => [
                    'is_extend' => true,
                    'owner' => ExtendScope::OWNER_CUSTOM,
                    'cascade' => ['persist'],
                    'on_delete' => 'CASCADE',
                ],
            ]
        );
    }

    public function setExtendExtension(ExtendExtension $extendExtension)
    {
        $this->extendExtension = $extendExtension;
    }
}
