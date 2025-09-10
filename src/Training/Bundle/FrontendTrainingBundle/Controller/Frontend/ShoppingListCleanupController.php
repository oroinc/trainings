<?php

namespace Training\Bundle\FrontendTrainingBundle\Controller\Frontend;

use Doctrine\Persistence\ManagerRegistry;
use Oro\Bundle\EntityExtendBundle\Tools\ExtendHelper;
use Oro\Bundle\ProductBundle\Entity\Product;
use Oro\Bundle\SecurityBundle\Attribute\AclAncestor;
use Oro\Bundle\ShoppingListBundle\Entity\ShoppingList;
use Oro\Bundle\ShoppingListBundle\Manager\ShoppingListManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Cleanup controller consists of single action cleanupAction that takes
 * shopping list by ID, iterates over its line items and removes those that
 * have "out of stock" status.
 */
class ShoppingListCleanupController extends AbstractController
{
    #[Route(
        path: '/cleanup/{id}',
        name: 'training_frontendtraining_frontend_shoppinglistcleanup_cleanup',
        requirements: ['id' => '\d+'],
        methods: ['POST'],
        options: ['expose' => true]
    )]
    #[AclAncestor('oro_shopping_list_frontend_update')]
    public function cleanupAction(ShoppingList $shoppingList): JsonResponse
    {
        foreach ($shoppingList->getLineItems() as $lineItem) {
            $inventoryStatusId = $lineItem->getProduct()?->getInventoryStatus()?->getId();
            $oosStatusId = ExtendHelper::buildEnumOptionId(
                Product::INVENTORY_STATUS_ENUM_CODE,
                Product::INVENTORY_STATUS_OUT_OF_STOCK
            );
            if ($inventoryStatusId === $oosStatusId) {
                $this->container->get('oro_shopping_list.manager.shopping_list')->removeLineItem($lineItem);
            }
        }

        $this->container->get('doctrine')->getManagerForClass(ShoppingList::class)->flush();

        return new JsonResponse(['success' => true]);
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            'oro_shopping_list.manager.shopping_list' => ShoppingListManager::class,
            'doctrine' => ManagerRegistry::class
        ]);
    }
}
