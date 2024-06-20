<?php

namespace Acme\Bundle\FrontendDashboardsBundle\DependencyInjection;

use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Oro\Bundle\ConfigBundle\DependencyInjection\SettingsBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public const ROOT_NODE = 'acme_frontend_dashboards';

    public const CNF_DASHBOARD_ORDER_NUMBER = 'dashboard_order_number';
    public const CNF_DASHBOARD_DATAGRID_REFRESH_SEC = 'dashboard_datagrid_refresh_sec';

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(self::ROOT_NODE);
        $rootNode = $treeBuilder->getRootNode();

        SettingsBuilder::append(
            $rootNode,
            [
                self::CNF_DASHBOARD_ORDER_NUMBER => ['value' => 5, 'type' => 'integer'],
                self::CNF_DASHBOARD_DATAGRID_REFRESH_SEC => ['value' => 10, 'type' => 'integer'],
            ]
        );

        return $treeBuilder;
    }

    public static function getConfigKeyByName(string $name): string
    {
        return sprintf(
            '%s%s%s',
            self::ROOT_NODE,
            ConfigManager::SECTION_MODEL_SEPARATOR,
            $name
        );
    }
}
