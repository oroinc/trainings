<?php

namespace Training\Bundle\UserNamingBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Training\Bundle\UserNamingBundle\Entity\UserNamingIntegrationSettings;

class UserNamingIntegrationSettingsRepository extends EntityRepository
{
    /**
     * @param integer|null $channelId
     * @return UserNamingIntegrationSettings[]
     */
    public function findByEnabledChannel($channelId = null)
    {
        $qb = $this->createQueryBuilder('settings')
            ->innerJoin('settings.channel', 'channel')
            ->andWhere('channel.enabled = true');

        if ($channelId) {
            $qb->andWhere('settings.id = :channelId')
                ->setParameter('channelId', $channelId);
        }

        return $qb->getQuery()->getResult();
    }
}
