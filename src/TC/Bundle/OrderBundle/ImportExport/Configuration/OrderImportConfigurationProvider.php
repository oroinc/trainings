<?php

namespace TC\Bundle\OrderBundle\ImportExport\Configuration;

use Oro\Bundle\ImportExportBundle\Configuration\ImportExportConfiguration;
use Oro\Bundle\ImportExportBundle\Configuration\ImportExportConfigurationInterface;
use Oro\Bundle\ImportExportBundle\Configuration\ImportExportConfigurationProviderInterface;
use Oro\Bundle\OrderBundle\Entity\Order;
use Symfony\Contracts\Translation\TranslatorInterface;

class OrderImportConfigurationProvider implements ImportExportConfigurationProviderInterface
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function get(): ImportExportConfigurationInterface
    {
        return new ImportExportConfiguration([
            ImportExportConfiguration::FIELD_ENTITY_CLASS => Order::class,
            ImportExportConfiguration::FIELD_IMPORT_PROCESSOR_ALIAS => 'tc_order.add',
            ImportExportConfiguration::FIELD_EXPORT_TEMPLATE_PROCESSOR_ALIAS => 'tc_order.template',
            ImportExportConfiguration::FIELD_IMPORT_STRATEGY_TOOLTIP =>
                $this->translator->trans('tc.order.import.strategy.tooltip'),
        ]);
    }
}
