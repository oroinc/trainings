<?php

namespace TC\Bundle\ProductBundle\EventListener;

use Oro\Bundle\OrderBundle\Entity\Order;
use Oro\Bundle\ProductBundle\Search\Reindex\ProductReindexManager;

class OrderListener
{
    public function __construct(private ProductReindexManager $productReindexManager)
    {
    }

    public function postPersist(Order $order): void
    {
        $this->reindexProducts($order);
    }

    public function postRemove(Order $order): void
    {
        $this->reindexProducts($order);
    }

    private function reindexProducts(Order $order): void
    {
        $productIds = [];
        foreach ($order->getLineItems() as $lineItem) {
            $productIds[] = $lineItem->getProduct()->getId();
        }
        $this->productReindexManager->reindexProducts($productIds);
    }
}
