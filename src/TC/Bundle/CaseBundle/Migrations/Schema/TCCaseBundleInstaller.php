<?php

namespace TC\Bundle\CaseBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;

use Oro\Bundle\CustomerBundle\Form\Type\CustomerSelectType;
use Oro\Bundle\CustomerBundle\Form\Type\CustomerUserSelectType;
use Oro\Bundle\EntityBundle\EntityConfig\DatagridScope;
use Oro\Bundle\EntityExtendBundle\EntityConfig\ExtendScope;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtension;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtensionAwareInterface;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class TCCaseBundleInstaller implements Installation, ExtendExtensionAwareInterface
{
    protected ExtendExtension $extendExtension;

    public function setExtendExtension(ExtendExtension $extendExtension)
    {
        $this->extendExtension = $extendExtension;
    }

    public function getMigrationVersion()
    {
        return 'v1_0';
    }

    public function up(Schema $schema, QueryBag $queries)
    {
        $this->extendCaseTable($schema);
    }

    /**
     * Enables Case activity for Customer and CustomerUser entity
     */
    public function extendCaseTable(Schema $schema)
    {
        $table = $schema->getTable('orocrm_case');

        $this->extendExtension->addManyToOneRelation(
            $schema,
            $table,
            'customer',
            'oro_customer',
            'name',
            [
                'extend' => [
                    'is_extend'     => true,
                    'owner'         => ExtendScope::OWNER_CUSTOM
                ],
                'datagrid'      => [
                    'is_visible'    => DatagridScope::IS_VISIBLE_FALSE
                ],
                'view'          => ['is_displayable' => true],
                'form'          => [
                    'is_enabled'    => true,
                    'form_type'     => CustomerSelectType::class,
                    'form_options'  => [
                        'label'  => 'oro.case.caseentity.customer.label'
                    ]
                ]
            ]
        );

        $this->extendExtension->addManyToOneRelation(
            $schema,
            $table,
            'customer_user',
            'oro_customer_user',
            'username',
            [
                'extend' => [
                    'is_extend'     => true,
                    'owner'         => ExtendScope::OWNER_CUSTOM
                ],
                'datagrid'      => [
                    'is_visible'    => DatagridScope::IS_VISIBLE_FALSE
                ],
                'view'          => ['is_displayable' => true],
                'form'          => [
                    'is_enabled'    => true,
                    'form_type'     => CustomerUserSelectType::class,
                    'form_options'  => [
                        'label'  => 'oro.case.caseentity.customer_user.label'
                    ]
                ]
            ]
        );
    }
}
