<?php

namespace Training\Bundle\FrontendTrainingBundle\Controller\Frontend;

use Oro\Bundle\ProductBundle\Entity\Product;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Oro\Bundle\ShoppingListBundle\Entity\ShoppingList;
use Oro\Bundle\ShoppingListBundle\Manager\ShoppingListManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Cleanup controller consists of single action cleanupAction that takes
 * shopping list by ID, iterates over its line items and removes those that
 * are not in stock - their status is set to "out of stock".
 */
class ShoppingListCleanupController extends AbstractController
{
    /**
     * @Route(
     *     "/cleanup/{id}",
     *     name="training_bundle_frontendtraining_frontend_shoppinglistcleanup_cleanup",
     *     requirements={"id"="\d+"},
     *     methods={"POST"},
     *     options={"expose"=true}
     * )
     * @AclAncestor("oro_shopping_list_frontend_update")
     * @param ShoppingList $shoppingList
     * @return JsonResponse
     */
    public function cleanupAction(ShoppingList $shoppingList): JsonResponse
    {
        foreach ($shoppingList->getLineItems() as $lineItem) {
            if ($lineItem->getProduct()?->getInventoryStatus()?->getId() === Product::INVENTORY_STATUS_OUT_OF_STOCK) {
                $this->container->get('oro_shopping_list.manager.shopping_list')->removeLineItem($lineItem);
            }
        }

        $this->container->get('doctrine')->getManagerForClass(ShoppingList::class)->flush();

        return new JsonResponse(['success' => true], Response::HTTP_OK);
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedServices()
    {
        return array_merge(parent::getSubscribedServices(), [
            'oro_shopping_list.manager.shopping_list' => ShoppingListManager::class,
        ]);
    }
}
