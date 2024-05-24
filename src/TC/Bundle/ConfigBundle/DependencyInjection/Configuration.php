<?php

namespace TC\Bundle\ConfigBundle\DependencyInjection;

use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Oro\Bundle\ConfigBundle\DependencyInjection\SettingsBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public const CONFIG_TIMEZONE_INDICATOR_ENABLED = 'timezone_indicator_enabled';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(TCConfigExtension::ALIAS);
        $rootNode = $treeBuilder->getRootNode();

        SettingsBuilder::append(
            $rootNode,
            [
                self::CONFIG_TIMEZONE_INDICATOR_ENABLED => ['type' => 'boolean', 'value' => false],
            ]
        );

        return $treeBuilder;
    }

    public static function getConfigKey(string $name): string
    {
        return TCConfigExtension::ALIAS . ConfigManager::SECTION_MODEL_SEPARATOR . $name;
    }
}
