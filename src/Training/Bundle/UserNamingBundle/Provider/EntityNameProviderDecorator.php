<?php

namespace Training\Bundle\UserNamingBundle\Provider;

use Oro\Bundle\EntityBundle\Provider\EntityNameProviderInterface;
use Oro\Bundle\UserBundle\Entity\User;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

class EntityNameProviderDecorator implements EntityNameProviderInterface
{
    /** @var EntityNameProviderInterface */
    private $originalProvider;

    /** @var UserFullNameProvider */
    private $fullNameProvider;

    /**
     * @param EntityNameProviderInterface $originalProvider
     * @param UserFullNameProvider $fullNameProvider
     */
    public function __construct(
        EntityNameProviderInterface $originalProvider,
        UserFullNameProvider $fullNameProvider
    ) {
        $this->originalProvider = $originalProvider;
        $this->fullNameProvider = $fullNameProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getName($format, $locale, $entity)
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
    public function getNameDQL($format, $locale, $className, $alias)
    {
        return $this->originalProvider->getNameDQL($format, $locale, $className, $alias);
    }
}
