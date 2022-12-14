<?php

namespace Training\Bundle\UserNamingBundle\Provider;

use Oro\Bundle\EntityBundle\Provider\EntityNameProviderInterface;
use Oro\Bundle\UserBundle\Entity\User;

/**
 * Provides custom full name representation for Entity User
 */
class UserNameProvider implements EntityNameProviderInterface
{
    private const NAME_FORMAT = '%last_name% %first_name% %middle_name%';

    public function __construct(
        private readonly EntityNameProviderInterface $originalEntityNameProvider
    ) {
    }

    /**
     * Returns custom user full name representation
     *
     * {@inheritdoc}
     */
    public function getName($format, $locale, $entity): string
    {
        if (!$entity instanceof User) {
            return $this->getName($format, $locale, $entity);
        }

        $replacements = [
            '%last_name%' => $entity->getLastName(),
            '%first_name%' => $entity->getFirstName(),
            '%middle_name%' => $entity->getMiddleName(),
        ];

        return str_replace(array_keys($replacements), array_values($replacements), self::NAME_FORMAT);
    }

    /**
     * {@inheritdoc}
     */
    public function getNameDQL($format, $locale, $className, $alias): string
    {
        return $this->originalEntityNameProvider->getNameDQL($format, $locale, $className, $alias);
    }
}
