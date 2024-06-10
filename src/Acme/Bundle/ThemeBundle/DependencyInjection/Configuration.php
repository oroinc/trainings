<?php

namespace Acme\Bundle\ThemeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Oro\Bundle\ConfigBundle\DependencyInjection\SettingsBuilder;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see
 * {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    public const ROOT_NODE = 'acme_theme';
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(SELF::ROOT_NODE);
        $rootNode = $treeBuilder->getRootNode();

        SettingsBuilder::append(
            $rootNode,
            [
                'custom_backend_css'    => ['value' => null],
                'social_facebook'       => ['value' => 'https://www.facebook.com/acmedemo'],
                'social_instagram'      => ['value' => 'https://www.instagram.com/acmedemo/?hl=en'],
                'social_twitter'        => ['value' => 'https://twitter.com/acmedemo'],
                'social_linkedin'       => ['value' => 'https://www.linkedin.com/company/acmedemo'],
                'social_youtube'        => ['value' => 'https://www.youtube.com/channel/acmedemo']
            ]
        );
        return $treeBuilder;
    }
}
