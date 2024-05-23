<?php

namespace TC\Bundle\CustomerBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Oro\Bundle\EntityBundle\EntityConfig\DatagridScope;
use Oro\Bundle\EntityExtendBundle\EntityConfig\ExtendScope;
use Oro\Bundle\EntityExtendBundle\Migration\OroOptions;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class TCCustomerBundleInstaller implements Installation
{
    public function getMigrationVersion()
    {
        return 'v1_0';
    }

    public function up(Schema $schema, QueryBag $queries)
    {
        $this->addCUPhoneField($schema);
    }

    public function addCUPhoneField(Schema $schema)
    {
        $table = $schema->getTable('oro_customer_user');

        $table->addColumn(
            'phone',
            Types::STRING,
            [
                'notnull' => false,
                'length' => 255,
                OroOptions::KEY => [
                    'extend'    => ['is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM],
                    'datagrid'  => ['is_visible' => DatagridScope::IS_VISIBLE_HIDDEN],
                    'form'      => ['is_enabled' => true],
                    'view'      => ['is_displayable' => true],
                    'frontend'  => [
                        'is_editable' => true,
                    ],
                ]
            ]
        );
    }
}
