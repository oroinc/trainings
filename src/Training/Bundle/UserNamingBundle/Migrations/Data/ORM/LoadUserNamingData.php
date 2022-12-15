<?php

namespace Training\Bundle\UserNamingBundle\Migrations\Data\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

class LoadUserNamingData extends AbstractFixture
{
    private array $userNamings = [
        [
            'title' => 'Official',
            'format' => 'PREFIX FIRST MIDDLE LAST SUFFIX'
        ],
        [
            'title' => 'Unofficial',
            'format' => 'FIRST LAST'
        ],
        [
            'title' => 'First name only',
            'format' => 'FIRST'
        ]
    ];

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->userNamings as $userNamingItem) {
            $userNamingType = new UserNamingType();

            $userNamingType
                ->setTitle($userNamingItem['title'])
                ->setFormat($userNamingItem['format']);

            $manager->persist($userNamingType);
        }

        if (!empty($this->userNamings)) {
            $manager->flush();
            $manager->clear();
        }
    }
}
