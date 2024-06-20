<?php

namespace Acme\Bundle\CustomValidationBundle\DependencyInjection;

use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Oro\Bundle\ConfigBundle\DependencyInjection\SettingsBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public const ROOT_NODE = 'acme_custom_validation';
    public const CNF_ALLOWED_EMAIL_DOMAIN = 'allowed_email_domain';

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
                self::CNF_ALLOWED_EMAIL_DOMAIN => ['value' => null, 'type' => 'string'],
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
