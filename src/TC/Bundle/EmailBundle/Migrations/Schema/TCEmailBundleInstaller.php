<?php

namespace TC\Bundle\EmailBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\EntityConfigBundle\Migration\UpdateEntityConfigFieldValueQuery;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;
use Oro\Bundle\OrderBundle\Entity\Order;

class TCEmailBundleInstaller implements Installation
{
    public function getMigrationVersion()
    {
        return 'v1_0';
    }

    public function up(Schema $schema, QueryBag $queries)
    {
        $this->exposeShippingTrackingForEmails($queries);
    }

    protected function exposeShippingTrackingForEmails(QueryBag $queries)
    {
        $queries->addQuery(new UpdateEntityConfigFieldValueQuery(
            Order::class,
            'shippingTrackings',
            'email',
            'available_in_template',
            true
        ));
    }
}
