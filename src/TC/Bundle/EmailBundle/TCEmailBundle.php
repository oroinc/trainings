<?php

namespace TC\Bundle\EmailBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use TC\Bundle\EmailBundle\DependencyInjection\CompilerPass\TwigSandboxConfigurationPass;

class TCEmailBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new TwigSandboxConfigurationPass());

        parent::build($container);
    }
}
