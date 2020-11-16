<?php

namespace Training\Bundle\UserNamingBundle\Tests\Behat;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Persistence\ObjectRepository;
use Oro\Bundle\TestFrameworkBundle\Behat\Isolation\ReferenceRepositoryInitializerInterface;
use Oro\Bundle\TestFrameworkBundle\Test\DataFixtures\Collection;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

/**
 * Loads Naming Types and creates fixture reference for each in form of:
 *
 *  - user_naming_type_official
 *  - user_naming_type_unofficial
 *  - user_naming_type_first_name_only
 */
class ReferenceRepositoryInitializer implements ReferenceRepositoryInitializerInterface
{
    private const TYPE_PLACEHOLDER = 'user_naming_type_%s';

    /**
     * {@inheritdoc}
     */
    public function init(Registry $doctrine, Collection $referenceRepository): void
    {
        $this->setNamingTypesReferences($doctrine, $referenceRepository);
    }

    /**
     * @param Registry $doctrine
     * @param Collection $referenceRepository
     */
    private function setNamingTypesReferences(Registry $doctrine, Collection $referenceRepository): void
    {
        /** @var ObjectRepository $repository */
        $repository = $doctrine
            ->getManagerForClass(UserNamingType::class)
            ->getRepository(UserNamingType::class);

        /** @var UserNamingType $namingType */
        foreach ($repository->findAll() as $namingType) {
            $referenceRepository->set(
                sprintf(self::TYPE_PLACEHOLDER, $this->normalizeName($namingType->getTitle())),
                $namingType
            );
        }
    }

    /**
     * @param string $title
     * @return string
     */
    private function normalizeName(string $title): string
    {
        return strtolower(str_replace(' ', '_', $title));
    }
}
