<?php

namespace TC\Bundle\ProductBundle\EventListener;

use Oro\Bundle\CatalogBundle\Search\ProductRepository;
use Oro\Bundle\DataGridBundle\Datasource\ResultRecordInterface;
use Oro\Bundle\DataGridBundle\Event\BuildBefore;
use Oro\Bundle\SearchBundle\Datagrid\Event\SearchResultAfter;

class FrontendProductDatagridListener
{
    public function __construct(
        private ProductRepository $searchRepository
    ) {
    }

    public function onResultAfter(SearchResultAfter $event): void
    {
        $records = $event->getRecords();
        $topSelling = $this->searchRepository->getTopSellingProducts();

        foreach ($records as $record) {
            $this->setIsTopSelling($record, $topSelling);
        }

        $event->setRecords($records);
    }

    public function onBuildBefore(BuildBefore $event)
    {
        $config = $event->getConfig();
        $config->addColumn(
            'is_top_selling',
            [
                'is_top_selling' => [
                    'label' => 'tc.product.top_selling.label'
                ],
            ]
        );
    }

    protected function setIsTopSelling(ResultRecordInterface $record, array $topSelling): void
    {
        $productId = $record->getValue('id');
        $record->setValue('is_top_selling', array_key_exists($productId, $topSelling));
    }
}
