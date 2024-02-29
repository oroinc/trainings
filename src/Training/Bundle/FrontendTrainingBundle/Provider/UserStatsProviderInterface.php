<?php

namespace Training\Bundle\FrontendTrainingBundle\Provider;

use Oro\Bundle\CustomerBundle\Entity\Customer;
use Training\Bundle\FrontendTrainingBundle\Provider\DTO\UserStat;

interface UserStatsProviderInterface
{
    /**
     * @param Customer $customer
     * @return UserStat[]
     */
    public function getUserStats(Customer $customer): array;
}
