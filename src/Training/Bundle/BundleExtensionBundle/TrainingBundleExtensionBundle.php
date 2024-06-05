<?php

namespace Training\Bundle\BundleExtensionBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Training\Bundle\BundleExtensionBundle\DependencyInjection\TrainingBundleExtensionExtension;

class TrainingBundleExtensionBundle extends Bundle
{
    protected function getContainerExtensionClass(): string
    {
        return TrainingBundleExtensionExtension::class;
    }
}
