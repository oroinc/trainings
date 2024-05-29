<?php

namespace TC\Bundle\ProductBundle\EventListener;

use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Oro\Bundle\OrderBundle\Entity\OrderLineItem;
use Oro\Bundle\ProductBundle\Entity\Product;
use Oro\Bundle\WebsiteSearchBundle\Event\IndexEntityEvent;

class WebsiteSearchProductIndexerListener
{
    public const string TOTAL_SOLD_FIELD_NAME = 'totalSold';

    public function __construct(private DoctrineHelper $doctrineHelper)
    {
    }

    public function onWebsiteSearchIndex(IndexEntityEvent $event): void
    {
        /** @var Product[] $products */
        $products = $event->getEntities();
        $productIds = array_map(fn(Product $product) => $product->getId(), $products);
        $totalSold = $this->getProductsTotalSold($productIds);

        // iterate over entities that have to be indexed
        foreach ($products as $product) {
            $event->addField(
                $product->getId(),
                self::TOTAL_SOLD_FIELD_NAME,
                $totalSold[$product->getId()] ?? 0
            );
        }
    }

    private function getProductsTotalSold(array $productIds): array
    {
        $result = $this->doctrineHelper->getEntityRepositoryForClass(OrderLineItem::class)
            ->createQueryBuilder('oli')
            ->select('IDENTITY(oli.product) as productId, SUM(oli.quantity) as totalSold')
            ->where('oli.product IN (:productIds)')
            ->groupBy('oli.product')
            ->setParameter('productIds', $productIds)
            ->getQuery()
            ->getArrayResult();

        $totalSold = [];
        foreach ($result as $row) {
            $totalSold[$row['productId']] = (int)$row['totalSold'];
        }

        return $totalSold;
    }
}
