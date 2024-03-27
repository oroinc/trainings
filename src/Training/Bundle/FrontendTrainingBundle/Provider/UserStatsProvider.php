<?php

namespace Training\Bundle\FrontendTrainingBundle\Provider;

use Doctrine\Persistence\ManagerRegistry;
use Oro\Bundle\CustomerBundle\Entity\Customer;
use Oro\Bundle\CustomerBundle\Entity\CustomerUser;
use Oro\Bundle\OrderBundle\Entity\Order;
use Training\Bundle\FrontendTrainingBundle\Provider\DTO\UserStat;

class UserStatsProvider implements UserStatsProviderInterface
{
    public function __construct(private readonly ManagerRegistry $doctrine)
    {
    }

    public function getUserStats(Customer $customer): array
    {
        return array_map(function (array $datum) {
            return new UserStat($datum['fName'], $datum['lName'], $datum['email'], (int)$datum['orderCount']);
        }, $this->getUsersWithStats($customer));
    }

    private function getUsersWithStats(Customer $customer): array
    {
        $qb = $this
            ->doctrine
            ->getRepository(CustomerUser::class)
            ->createQueryBuilder('cu');

        $qb
            ->select('cu.firstName AS fName, cu.lastName AS lName, cu.email AS email, COUNT(o.id) AS orderCount')
            ->leftJoin(Order::class, 'o', 'WITH', 'o.customerUser = cu')
            ->where($qb->expr()->in('cu.customer', ':customers'))
            ->setParameter('customers', $this->getAllCustomers($customer))
            ->groupBy('cu.firstName, cu.lastName, cu.email');

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @return Customer[]
     */
    private function getAllCustomers(Customer $customer, array &$customers = []): array
    {
        $customers[] = $customer;
        foreach ($customer->getChildren() as $childCustomer) {
            $customers = $this->getAllCustomers($childCustomer, $customers);
        }

        return $customers;
    }
}
