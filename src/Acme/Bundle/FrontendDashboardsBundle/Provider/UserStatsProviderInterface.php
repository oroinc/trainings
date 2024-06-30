<?php

namespace Acme\Bundle\FrontendDashboardsBundle\Provider;

use Oro\Bundle\CustomerBundle\Entity\Customer;
use Acme\Bundle\FrontendDashboardsBundle\Provider\DTO\UserStat;

interface UserStatsProviderInterface
{
    /**
     * @param Customer $customer
     * @return UserStat[]
     */
    public function getUserStats(Customer $customer): array;
}
