<?php

namespace TC\Bundle\ProductBundle\EventListener;

use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Oro\Bundle\ProductBundle\Entity\Product;
use Oro\Bundle\ProductBundle\Event\BuildQueryProductListEvent;
use Oro\Bundle\ProductBundle\Event\BuildResultProductListEvent;
use TC\Bundle\ProductBundle\Provider\InventoryLevelProvider;

class ProductListInventoryListener
{
    public function __construct(
        private InventoryLevelProvider $inventoryLevelProvider,
        private DoctrineHelper $doctrineHelper
    ) {
    }

    public function onBuildQuery(BuildQueryProductListEvent $event): void
    {
        $event->getQuery()
            ->addSelect('text.category_title_LOCALIZATION_ID as categoryTitle');
    }

    public function onBuildResult(BuildResultProductListEvent $event): void
    {
        $products = $this->getProducts(array_keys($event->getProductData()));
        if (!$products) {
            return;
        }

        $inventoryLevels = $this->inventoryLevelProvider->getProductSellableUnitsInventoryLevels($products);

        foreach ($event->getProductData() as $productId => $data) {
            $productView = $event->getProductView($productId);
            $productView->set('categoryTitle', $data['categoryTitle']);
            $productView->set('inventoryLevelByUnit', $inventoryLevels[$productId]);
        }
    }

    /**
     * @param array|int[] $productIds
     * @return array|Product[]
     */
    protected function getProducts(array $productIds): array
    {
        return array_map(
            function (int $productId) {
                return $this->doctrineHelper->getEntityReference(Product::class, $productId);
            },
            $productIds
        );
    }
}
