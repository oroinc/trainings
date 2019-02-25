<?php

namespace Training\Bundle\UserNamingBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Training\Bundle\UserNamingBundle\Entity\UserNamingIntegrationSettings;

class UserNamingIntegrationSettingsRepository extends EntityRepository
{
    /**
     * @return UserNamingIntegrationSettings[]
     */
    public function findByEnabledChannel()
    {
        return $this->createQueryBuilder('settings')
            ->innerJoin('settings.channel', 'channel')
            ->andWhere('channel.enabled = true')
            ->orderBy('settings.id')
            ->getQuery()
            ->getResult();
    }
}
