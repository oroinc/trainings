<?php

namespace Training\Bundle\NewThemeBundle\DependencyInjection;

use Oro\Bundle\ConfigBundle\DependencyInjection\SettingsBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public const ROOT_NODE = 'training_new_theme';

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
                'store_phone'         => ['value' => '+19012345678'],
                'store_support_email' => ['value' => 'mail@example.com'],
                'store_youtube_chanel' => ['value' => 'https://www.youtube.com/']
            ]
        );

        return $treeBuilder;
    }
}
