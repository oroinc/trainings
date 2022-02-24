<?php

namespace Training\Bundle\UserNamingBundle\ImportExport\TemplateFixture;

use Oro\Bundle\ImportExportBundle\TemplateFixture\AbstractTemplateRepository;
use Oro\Bundle\ImportExportBundle\TemplateFixture\TemplateFixtureInterface;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

class UserNamingTypeFixture extends AbstractTemplateRepository implements TemplateFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function getEntityClass(): string
    {
        return UserNamingType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): \Iterator
    {
        return $this->getEntityData('Full name');
    }

    /**
     * {@inheritdoc}
     */
    protected function createEntity($key)
    {
        return new UserNamingType();
    }

    /**
     * @param string $key
     * @param UserNamingType $entity
     */
    public function fillEntityData($key, $entity)
    {
        switch ($key) {
            case 'Full name':
                $entity
                    ->setTitle('Full name')
                    ->setFormat('PREFIX FIRST MIDDLE LAST SUFFIX');

                return;
        }

        parent::fillEntityData($key, $entity);
    }
}
