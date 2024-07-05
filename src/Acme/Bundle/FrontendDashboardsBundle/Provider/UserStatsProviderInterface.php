<?php

namespace Acme\Bundle\FrontendDashboardsBundle\Provider;

use Acme\Bundle\FrontendDashboardsBundle\Provider\DTO\UserStat;
use Oro\Bundle\CustomerBundle\Entity\Customer;

interface UserStatsProviderInterface
{
    /**
     * @param Customer $customer
     * @return UserStat[]
     */
    public function getUserStats(Customer $customer): array;
}
