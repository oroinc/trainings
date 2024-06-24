<?php

namespace TC\Bundle\UserBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\EntityBundle\EntityConfig\DatagridScope;
use Oro\Bundle\EntityExtendBundle\EntityConfig\ExtendScope;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class TCUserBundleInstaller implements Installation
{
    public function getMigrationVersion()
    {
        return 'v1_0';
    }

    public function up(Schema $schema, QueryBag $queries)
    {
        $this->addFullNameExtendedColumn($schema);
    }

    protected function addFullNameExtendedColumn(Schema $schema)
    {
        $table = $schema->getTable('oro_user');
        $table->addColumn(
            'full_name_extended',
            'string',
            [
                'notnull' => false,
                'length' => 255,
                'oro_options' => [
                    'extend' => ['owner' => ExtendScope::OWNER_CUSTOM],
                    'form' => ['is_enabled' => false],
                    'datagrid' => ['is_visible' => DatagridScope::IS_VISIBLE_HIDDEN]
                ],
            ]
        );
    }
}
