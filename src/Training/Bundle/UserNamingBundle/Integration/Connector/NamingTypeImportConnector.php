<?php

namespace Training\Bundle\UserNamingBundle\Integration\Connector;

use Psr\Log\LoggerInterface;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Training\Bundle\UserNamingBundle\Entity\Repository\UserNamingIntegrationSettingsRepository;
use Training\Bundle\UserNamingBundle\Entity\UserNamingIntegrationSettings;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;
use Training\Bundle\UserNamingBundle\Integration\NamingTypeTransport;

/**
 * IMPORTANT!!! This class is added just to demonstrate how to use integration data - please, don't follow this approach
 * in production code. Proper way to import data using an integration is to implement integration connector
 * (using interface Oro\Bundle\IntegrationBundle\Provider\ConnectorInterface) and run sync process.
 */
class NamingTypeImportConnector
{
    /** @var DoctrineHelper */
    private $doctrineHelper;

    /** @var LoggerInterface */
    private $logger;

    /** @var NamingTypeTransport */
    private $transport;

    /**
     * @param DoctrineHelper  $doctrineHelper
     * @param LoggerInterface $logger
     * @param NamingTypeTransport $transport
     */
    public function __construct(
        DoctrineHelper $doctrineHelper,
        LoggerInterface $logger,
        NamingTypeTransport $transport
    ) {
        $this->doctrineHelper = $doctrineHelper;
        $this->logger = $logger;
        $this->transport = $transport;
    }

    /**
     * @return array ['invalid' => <integer>, 'skipped' => <integer>, 'added' => <integer>]
     */
    public function importNameTypes()
    {
        /** @var UserNamingIntegrationSettingsRepository $settingsRepository */
        $settingsRepository = $this->doctrineHelper->getEntityRepository(UserNamingIntegrationSettings::class);
        $namingTypeRepository = $this->doctrineHelper->getEntityRepository(UserNamingType::class);
        $namingTypeManager = $this->doctrineHelper->getEntityManager(UserNamingType::class);

        $generalStatistics = ['invalid' => 0, 'skipped' => 0, 'added' => 0];
        $settingsEntities = $settingsRepository->findByEnabledChannel();

        foreach ($settingsEntities as $settings) {
            $channelId = $settings->getId();
            $jsonData = $this->transport->getNamingTypeData($channelId);

            $invalidCount = 0;
            $skippedCount = 0;
            $addedCount = 0;

            foreach ($jsonData as $namingTypeItem) {
                if (!array_key_exists('title', $namingTypeItem) || !array_key_exists('format', $namingTypeItem)) {
                    $invalidCount++;
                    continue;
                }

                $title = $namingTypeItem['title'];
                $format = $namingTypeItem['format'];

                $existingNamingType = $namingTypeRepository->findOneBy(['title' => $title]);
                if ($existingNamingType) {
                    $skippedCount++;
                    continue;
                }

                $newNamingType = new UserNamingType();
                $newNamingType->setTitle($title)
                    ->setFormat($format);

                $namingTypeManager->persist($newNamingType);
                $addedCount++;
            }

            if ($addedCount > 0) {
                $namingTypeManager->flush();
            }

            $this->logger->info('Naming types were processed', [
                'channelId' => $channelId,
                'invalid' => $invalidCount,
                'skipped' => $skippedCount,
                'added' => $addedCount,
            ]);

            $generalStatistics['invalid'] += $invalidCount;
            $generalStatistics['skipped'] += $skippedCount;
            $generalStatistics['added'] += $addedCount;
        }

        return $generalStatistics;
    }
}
