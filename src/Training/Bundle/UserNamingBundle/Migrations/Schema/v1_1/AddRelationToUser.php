<?php

namespace Training\Bundle\UserNamingBundle\Migrations\Schema\v1_1;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\EntityExtendBundle\EntityConfig\ExtendScope;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtension;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtensionAwareInterface;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class AddRelationToUser implements Migration, ExtendExtensionAwareInterface
{
    private ExtendExtension $extendExtension;

    public function up(Schema $schema, QueryBag $queries)
    {
        $table = $schema->getTable('training_user_naming_type');

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
