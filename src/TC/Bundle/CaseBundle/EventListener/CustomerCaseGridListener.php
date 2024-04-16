<?php

namespace TC\Bundle\CaseBundle\EventListener;

use Oro\Bundle\DataGridBundle\Event\BuildAfter;

class CustomerCaseGridListener
{
    public function onBuildAfter(BuildAfter $event)
    {
        $config = $event->getDatagrid()->getConfig();

        $this->removeTags($config);
    }

    protected function removeTags($config)
    {
        $config->removeColumn('tags');
        $config->removeFilter('tagname');
    }
}
