<?php

namespace Acme\Bundle\OrderBundle\Migrations\Data\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\CommerceMenuBundle\Entity\MenuUpdate;
use Oro\Bundle\ScopeBundle\Entity\Scope;
use Oro\Bundle\ScopeBundle\Manager\ScopeManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Loads the menu items to "frontend_order_menu" storefront menu
 */
class LoadFrontendOrderMenuData extends AbstractFixture implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    const MENU = 'frontend_order_menu';

    protected static array $menuUpdates = [
        [
            'key' => 'featured_menu_order_history',
            'parent_key' => null,
            'default_title' => 'Order History',
            'titles' => [],
            'default_description' => 'Keep track of all current and submitted orders.',
            'descriptions' => [],
            'uri' => '/customer/order',
            'menu' => self::MENU,
            'active' => true,
            'priority' => 10,
            'divider' => false,
            'custom' => true,
            'icon' => 'fa-list-alt',
            'condition' => '',
            'screens' => [],
        ],
        [
            'key' => 'featured_menu_contact_us',
            'parent_key' => null,
            'default_title' => 'Contact us',
            'titles' => [],
            'default_description' => 'Need assistance with an order? Contact us for help.',
            'descriptions' => [],
            'uri' => '/contact-us',
            'menu' => self::MENU,
            'active' => true,
            'priority' => 20,
            'divider' => false,
            'custom' => true,
            'icon' => 'fa-envelope',
            'condition' => '',
            'screens' => [],
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $scope = $this->getScope();

        foreach (self::$menuUpdates as $menuUpdateData) {
            $menuUpdateData = ['scope' => $scope] + $menuUpdateData;
            /** @var MenuUpdate $menuUpdate */
            $menuUpdate = $this->createMenuUpdate($menuUpdateData);
            $manager->persist($menuUpdate);
        }

        $manager->flush();
    }

    protected function getScope(): Scope
    {
        /** @var ScopeManager $scopeManager */
        $scopeManager = $this->container->get('oro_scope.scope_manager');

        return $scopeManager->findOrCreate('menu_frontend_visibility', []);
    }

    protected function createMenuUpdate(array $data): MenuUpdate
    {
        $menuUpdate = new MenuUpdate();

        $menuUpdate->setKey($data['key']);
        $menuUpdate->setParentKey($data['parent_key']);
        $menuUpdate->setUri($data['uri']);
        $menuUpdate->setMenu($data['menu']);
        $menuUpdate->setActive($data['active']);
        $menuUpdate->setScope($data['scope']);
        $menuUpdate->setPriority($data['priority']);
        $menuUpdate->setDivider($data['divider']);
        $menuUpdate->setCustom($data['custom']);
        $menuUpdate->setIcon($data['icon']);
        $menuUpdate->setCondition($data['condition']);
        $menuUpdate->setScreens($data['screens']);

        $menuUpdate->setDefaultTitle($data['default_title']);
        $menuUpdate->setDefaultDescription($data['default_description']);

        return $menuUpdate;
    }
}
