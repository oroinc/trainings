<?php

namespace Acme\Bundle\ThemeBundle\DependencyInjection;

use Oro\Bundle\ConfigBundle\DependencyInjection\SettingsBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public const ROOT_NODE = 'acme_theme';

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
                'social_facebook'    => ['value' => 'https://www.facebook.com/acmedemo'],
                'social_instagram'   => ['value' => 'https://www.instagram.com/acmedemo/?hl=en'],
                'social_twitter'     => ['value' => 'https://twitter.com/acmedemo'],
                'social_linkedin'    => ['value' => 'https://www.linkedin.com/company/acmedemo'],
                'social_youtube'     => ['value' => 'https://www.youtube.com/channel/acmedemo']
            ]
        );

        return $treeBuilder;
    }
}
