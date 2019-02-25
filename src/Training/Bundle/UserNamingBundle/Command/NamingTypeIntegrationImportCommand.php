<?php

namespace Training\Bundle\UserNamingBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Training\Bundle\UserNamingBundle\Integration\Connector\NamingTypeImportConnector;

/**
 * IMPORTANT!!! This command is added just to demonstrate how to use integration data - please, don't follow this
 * approach in production code. Proper way to run import using an integration is automatic sync via cron command or
 * manual call of CLI command oro:cron:integration:sync with an appropriate parameters
 */
class NamingTypeIntegrationImportCommand extends Command
{
    /** @var NamingTypeImportConnector */
    private $importConnector;

    /** @var string */
    protected static $defaultName = 'training:naming-type:integration:import';

    /**
     * @required
     * @param NamingTypeImportConnector $importConnector
     */
    public function setImportConnector(NamingTypeImportConnector $importConnector)
    {
        $this->importConnector = $importConnector;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Import all naming types using active naming type integrations');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $statistics = $this->importConnector->importNameTypes();

        $output->writeln(sprintf('Invalid user naming types: %s.', $statistics['invalid']));
        $output->writeln(sprintf('Skipped user naming types: %s.', $statistics['skipped']));
        $output->writeln(sprintf('Added user naming types: %s.', $statistics['added']));
    }
}
