<?php

namespace Training\Bundle\UserNamingBundle\Provider;

use Oro\Bundle\EntityBundle\Provider\EntityNameProviderInterface;
use Oro\Bundle\UserBundle\Entity\User;

class EntityNameProviderDecorator implements EntityNameProviderInterface
{
    /** @var EntityNameProviderInterface */
    private $originalProvider;

    /**
     * @param EntityNameProviderInterface $originalProvider
     */
    public function __construct(EntityNameProviderInterface $originalProvider)
    {
        $this->originalProvider = $originalProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getName($format, $locale, $entity)
    {
        if ($entity instanceof User) {
            return sprintf('%s %s %s', $entity->getLastName(), $entity->getFirstName(), $entity->getMiddleName());
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
