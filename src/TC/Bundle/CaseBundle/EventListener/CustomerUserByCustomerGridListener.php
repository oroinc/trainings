<?php

namespace TC\Bundle\CaseBundle\EventListener;

use Oro\Bundle\CustomerBundle\Entity\CustomerUser;
use Oro\Bundle\DataGridBundle\Datasource\ResultRecordInterface;
use Oro\Bundle\DataGridBundle\Event\BuildBefore;
use Oro\Bundle\DataGridBundle\Event\OrmResultAfter;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;

class CustomerUserByCustomerGridListener
{
    public function __construct(private DoctrineHelper $doctrineHelper)
    {
    }

    public function onBuildBefore(BuildBefore $event)
    {
        $config = $event->getDatagrid()->getConfig();

        $this->addRolesColumn($config);
    }

    public function onResultAfter(OrmResultAfter $event)
    {
        $records = $event->getRecords();
        $this->addRolesToRecords($records);
    }

    protected function addRolesColumn($config)
    {
        $config->addColumn(
            'roles',
            [
                'label' => 'oro.customer.customeruser.roles.label',
                'type' => 'twig',
                'template' => '@TCCase/Customer/Datagrid/roles.html.twig',
                'frontend_type' => 'html',
                'renderable' => true,
            ],
        );
    }

    protected function addRolesToRecords(array $records)
    {
        $cuIds = array_map(
            function (ResultRecordInterface $record) {
                return $record->getValue('id');
            },
            $records
        );

        $customerUsers = $this->doctrineHelper
            ->getEntityRepository(CustomerUser::class)
            ->findBy(['id' => $cuIds]);

        $cuById = [];
        foreach ($customerUsers as $customerUser) {
            $cuById[$customerUser->getId()] = $customerUser;
        }

        foreach ($records as $record) {
            if (isset($cuById[$record->getValue('id')])) {
                $record->addData(['roles' => ($cuById[$record->getValue('id')])->getUserRoles()]);
            }
        }
    }
}
