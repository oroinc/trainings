<?php

namespace Training\Bundle\UserNamingBundle\Migrations\Data\ORM;

use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;
use Training\Bundle\UserNamingBundle\Provider\UserFullNameProvider;

class GenerateNameFormats extends AbstractFixture implements DependentFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function getDependencies(): array
    {
        return [LoadUserNamingTypes::class];
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $nameProvider = $this->container->get(UserFullNameProvider::class);

        $namingTypes = $manager
            ->getRepository(UserNamingType::class)
            ->findAll();

        foreach ($namingTypes as $namingType) {
            if (null === $namingType->getExample()) {
                $namingType->setExample($nameProvider->getFullNameExample($namingType->getFormat()));
            }
        }

        $manager->flush();
    }
}
