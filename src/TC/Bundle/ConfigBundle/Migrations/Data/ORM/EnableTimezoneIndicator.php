<?php

namespace TC\Bundle\ConfigBundle\Migrations\Data\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\UserBundle\DataFixtures\UserUtilityTrait;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use TC\Bundle\ConfigBundle\DependencyInjection\Configuration;

class EnableTimezoneIndicator extends AbstractFixture implements ContainerAwareInterface
{
    use ContainerAwareTrait;
    use UserUtilityTrait;

    public function load(ObjectManager $manager)
    {
        $configManager = $this->container->get('oro_config.global');

        $configManager->set(
            Configuration::getConfigKey(Configuration::CONFIG_TIMEZONE_INDICATOR_ENABLED),
            true
        );
        $configManager->flush();

        // per user
        $user = $this->getFirstUser($manager);

        $userConfigManager = $this->container->get('oro_config.user');

        $userConfigManager->set(
            Configuration::getConfigKey(Configuration::CONFIG_TIMEZONE_INDICATOR_ENABLED),
            false,
            $user->getId()
        );
        $userConfigManager->flush();
    }
}
