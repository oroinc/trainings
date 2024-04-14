<?php

namespace TC\Bundle\ProductBundle\Provider;

use Doctrine\Persistence\ManagerRegistry;
use Oro\Bundle\InventoryBundle\Entity\InventoryLevel;
use Oro\Bundle\ProductBundle\Entity\Product;

class InventoryLevelProvider
{
    public function __construct(private ManagerRegistry $doctrine)
    {
    }

    /**
     * @param Product[] $products
     * @return array [product id => [product unit => quantity, ...], ...]
     */
    public function getProductSellableUnitsInventoryLevels(array $products): array
    {
        return $this->formatProductInventoryLevels(
            $this->filterNonsellableUnits(
                $products,
                $this->doctrine->getRepository(InventoryLevel::class)->getQuantityForProductCollection($products)
            )
        );
    }

    protected function filterNonsellableUnits(array $products, array $productLevels): array
    {
        $productSellableUnits = [];
        foreach ($products as $product) {
            $productSellableUnits[$product->getId()] = array_keys($product->getSellUnitsPrecision());
        }

        $filteredLevels = [];
        foreach ($productLevels as $item) {
            if (isset($productSellableUnits[$item['product_id']])
                && in_array($item['code'], $productSellableUnits[$item['product_id']])) {
                $filteredLevels[] = $item;
            }
        }

        return $filteredLevels;
    }

    protected function formatProductInventoryLevels(array $productLevels): array
    {
        $formattedLevels = [];
        foreach ($productLevels as $item) {
            $formattedLevels[$item['product_id']][$item['code']] = $item['quantity'];
        }

        return $formattedLevels;
    }
}
