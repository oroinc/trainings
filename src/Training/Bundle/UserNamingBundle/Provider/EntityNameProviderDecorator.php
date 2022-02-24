<?php

namespace Training\Bundle\UserNamingBundle\Provider;

use Oro\Bundle\EntityBundle\Provider\EntityNameProviderInterface;
use Oro\Bundle\UserBundle\Entity\User;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

class EntityNameProviderDecorator implements EntityNameProviderInterface
{
    /**
     * @param EntityNameProviderInterface $originalProvider
     * @param UserFullNameProvider $fullNameProvider
     */
    public function __construct(
        private EntityNameProviderInterface $originalProvider,
        private UserFullNameProvider $fullNameProvider
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function getName($format, $locale, $entity): string
    {
        if ($entity instanceof User) {
            /** @var UserNamingType|null $namingType */
            $namingType = $entity->getNamingType();
            if ($namingType) {
                return $this->fullNameProvider->getFullName($entity, $namingType->getFormat());
            }
        }

        return $this->originalProvider->getName($format, $locale, $entity);
    }

    /**
     * {@inheritdoc}
     */
    public function getNameDQL($format, $locale, $className, $alias): string
    {
        return $this->originalProvider->getNameDQL($format, $locale, $className, $alias);
    }
}
