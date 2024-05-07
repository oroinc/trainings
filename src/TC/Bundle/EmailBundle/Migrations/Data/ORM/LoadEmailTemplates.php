<?php

namespace TC\Bundle\EmailBundle\Migrations\Data\ORM;

use Oro\Bundle\EmailBundle\Migrations\Data\ORM\AbstractHashEmailMigration;
use Oro\Bundle\MigrationBundle\Fixture\VersionedFixtureInterface;

class LoadEmailTemplates extends AbstractHashEmailMigration implements VersionedFixtureInterface
{
    public function getVersion()
    {
        return '1.3';
    }

    public function getEmailsDir()
    {
        return $this->container
            ->get('kernel')
            ->locateResource('@TCEmailBundle/Migrations/Data/ORM/emails');
    }

    protected function getEmailHashesToUpdate(): array
    {
        return [
            'order_shipped' => true,
            'customer_user_reset_password' => true
        ];
    }
}
