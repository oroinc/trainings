<?php

namespace Training\Bundle\UserNamingBundle\Migrations\Schema\v1_3;

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
        $table = $schema->getTable('training_user_naming_type');
        $table->addColumn('example', 'string', ['length' => 255, 'notnull' => false]);
    }
}
