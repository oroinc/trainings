<?php

namespace TC\Bundle\AccountBundle\Helper;

use Doctrine\ORM\EntityRepository;
use Oro\Bundle\AccountBundle\Entity\Account;
use Oro\Bundle\CustomerBundle\Entity\Customer;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Oro\Bundle\SalesBundle\Entity\Customer as SalesCustomer;

class CustomerFinder
{
    public function __construct(private DoctrineHelper $doctrineHelper)
    {
    }

    /**
     * @param Account $account
     * @return Customer[]
     */
    public function getRelatedToAccount(Account $account)
    {
        $customers = [];
        foreach ($this->getSalesCustomerRepository()->findBy(['account' => $account]) as $salesCustomer) {
            if ($salesCustomer->getCustomerTarget() instanceof Customer) {
                $customers[] = $salesCustomer->getCustomerTarget();
            }
        }

        return $customers;
    }

    private function getSalesCustomerRepository(): EntityRepository
    {
        return $this->doctrineHelper->getEntityRepository(SalesCustomer::class);
    }
}
