<?php

namespace TC\Bundle\EmailBundle\DependencyInjection\CompilerPass;

use Oro\Bundle\EmailBundle\DependencyInjection\Compiler\AbstractTwigSandboxConfigurationPass;

class TwigSandboxConfigurationPass extends AbstractTwigSandboxConfigurationPass
{

    protected function getFunctions(): array
    {
        return [
            'oro_order_format_shipping_tracking_link',
            'oro_order_format_shipping_tracking_method'
        ];
    }

    protected function getFilters(): array
    {
        return [];
    }

    protected function getTags(): array
    {
        return [];
    }

    protected function getExtensions(): array
    {
        return [
            'oro_order.twig.order'
        ];
    }
}
