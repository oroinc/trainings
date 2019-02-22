<?php

namespace Training\Bundle\UserNamingBundle\Migrations\Schema\v1_0;

use Doctrine\DBAL\Schema\Schema;

use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class TrainingUserNamingBundle implements Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        /** Tables generation **/
        $this->createTrainingUserNamingTypeTable($schema);
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
}
