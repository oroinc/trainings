<?php

namespace TC\Bundle\CheckoutBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\EntityExtendBundle\EntityConfig\ExtendScope;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class TCCheckoutBundleInstaller implements Installation
{
    public function getMigrationVersion(): string
    {
        return 'v1_0';
    }

    public function up(Schema $schema, QueryBag $queries): void
    {
        $this->addFieldsToOrder($schema);
    }

    protected function addFieldsToOrder(Schema $schema)
    {
        $table = $schema->getTable('oro_order');
        $table->addColumn(
            'contact_name',
            'string',
            [
                'notnull' => false,
                'length' => 255,
                'oro_options' => [
                    'extend' => ['owner' => ExtendScope::OWNER_CUSTOM],
                ]
            ]
        );
        $table->addColumn(
            'contact_phone',
            'string',
            [
                'notnull' => false,
                'length' => 255,
                'oro_options' => [
                    'extend' => ['owner' => ExtendScope::OWNER_CUSTOM],
                ]
            ]
        );
    }
}
