<?php

namespace Training\Bundle\CrmBundle\Twig;

use Doctrine\Common\Persistence\ManagerRegistry;
use Oro\Bundle\EntityExtendBundle\Tools\ExtendHelper;
use Oro\Bundle\SalesBundle\Entity\B2bCustomer;
use Oro\Bundle\SalesBundle\Entity\Opportunity;
use Oro\Bundle\SalesBundle\EntityConfig\CustomerScope;

class OpportunityExtension extends \Twig_Extension
{
    /** @var ManagerRegistry */
    private $managerRegistry;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('open_opportunities_for_b2b_customer', [$this, 'getOpportunitiesCount']),
        ];
    }

    /**
     * @param int $accountId
     * @return int
     */
    public function getOpportunitiesCount(int $accountId): int
    {
        $repository = $this->managerRegistry
            ->getManagerForClass(Opportunity::class)->getRepository(Opportunity::class);

        // exact column name can also be used: b2b_customer_188b774c
        $associationName = ExtendHelper::buildAssociationName(B2bCustomer::class, CustomerScope::ASSOCIATION_KIND);
        $qb = $repository->createQueryBuilder('o');
        $qb
            ->select('COUNT(o.id)')
            ->leftJoin('o.customerAssociation', 'ca')
            ->where($qb->expr()->isNotNull(sprintf('ca.%s', $associationName)))
            ->andWhere($qb->expr()->eq('ca.account', $accountId));

        $quantity = 0;
        try {
            $quantity = $qb->getQuery()->getSingleScalarResult();
        } catch (\Exception $exception) {
        }

        return $quantity;
    }
}
