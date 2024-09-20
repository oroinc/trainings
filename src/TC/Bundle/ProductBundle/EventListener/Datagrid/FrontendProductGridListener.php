<?php

namespace TC\Bundle\ProductBundle\EventListener\Datagrid;

use Oro\Bundle\DataGridBundle\Datasource\ResultRecordInterface;
use Oro\Bundle\DataGridBundle\Event\BuildBefore;
use Oro\Bundle\DataGridBundle\Extension\Formatter\Property\PropertyInterface;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Oro\Bundle\ProductBundle\Entity\Product;
use Oro\Bundle\SearchBundle\Datagrid\Event\SearchResultAfter;
use TC\Bundle\ProductBundle\Provider\InventoryLevelProvider;

class FrontendProductGridListener
{
    public function __construct(
        private InventoryLevelProvider $inventoryLevelProvider,
        private DoctrineHelper $doctrineHelper
    ) {
    }

    public function onBuildBefore(BuildBefore $event)
    {
        $config = $event->getConfig();
        $config->offsetAddToArrayByPath('[source][query][select]', [
            'text.category_title_LOCALIZATION_ID as categoryTitle'
        ]);
        $config->offsetAddToArrayByPath(
            '[properties]',
            [
                'categoryTitle' => [
                    'type'          => 'field',
                    'frontend_type' => PropertyInterface::TYPE_STRING
                ],
                'inventoryLevelByUnit' => [
                    'type'          => 'field',
                    'frontend_type' => PropertyInterface::TYPE_ROW_ARRAY
                ]
            ]
        );
    }

    public function onResultAfter(SearchResultAfter $event)
    {
        $products = $this->getProducts($event->getRecords());
        if (!$products) {
            return;
        }

        $inventoryLevels = $this->inventoryLevelProvider->getProductSellableUnitsInventoryLevels($products);

        foreach ($event->getRecords() as $record) {
            $record->addData([
                'inventoryLevelByUnit' => $inventoryLevels[$record->getValue('id')]
            ]);
        }
    }

    /**
     * @param array|ResultRecordInterface[] $productRecords
     * @return array|Product[]
     */
    protected function getProducts(array $productRecords): array
    {
        $productIds = array_map(
            function (ResultRecordInterface $record) {
                return $record->getValue('id');
            },
            $productRecords
        );
        return $this->doctrineHelper->getEntityRepositoryForClass(Product::class)->findBy(['id' => $productIds]);
    }
}
