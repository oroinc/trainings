<?php

namespace Training\Bundle\UserNamingBundle\ImportExport;

use Oro\Bundle\ImportExportBundle\TemplateFixture\AbstractTemplateRepository;
use Oro\Bundle\ImportExportBundle\TemplateFixture\TemplateFixtureInterface;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

class UserNamingTemplateFixture extends AbstractTemplateRepository implements TemplateFixtureInterface
{

    protected function createEntity($key): UserNamingType
    {
        return new UserNamingType();
    }

    public function getEntityClass(): string
    {
        return UserNamingType::class;
    }

    public function fillEntityData($key, $entity)
    {
        if ($key === 'Sample User Naming') {
            $entity->setId(1);
            $entity->setTitle('Test title');
            $entity->setFormat('FIRSTNAME LASTNAME');

            return;
        }

        parent::fillEntityData($key, $entity);
    }

    public function getData()
    {
        return $this->getEntityData('Sample User Naming');
    }
}
