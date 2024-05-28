<?php

namespace TC\Bundle\ProductBundle\Search;

use Oro\Bundle\CatalogBundle\Search\ProductRepository as BaseProductSearchRepository;
use Oro\Bundle\SearchBundle\Query\Result\Item;
use Oro\Bundle\WebsiteSearchBundle\Placeholder\WebsiteIdPlaceholder;

class ProductRepository extends BaseProductSearchRepository
{
    public function getTopSellingProducts($limit = 10)
    {
        $query = $this->createQuery();
        $query->addSelect('integer.system_entity_id as product_id')
            ->addSelect('integer.totalSold as totalSold')
            ->setOrderBy('integer.totalSold', 'DESC')
            ->setMaxResults($limit);

        $result = $query->getResult();
        $topSoldProducts = [];
        /** @var Item $item */
        foreach ($result as $item) {
            $topSoldProducts[$item->getSelectedData()['product_id']] = $item->getSelectedData()['totalSold'];
        }

        return $topSoldProducts;
    }
}
