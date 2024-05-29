<?php

namespace TC\Bundle\SalesBundle\Migrations\Data\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class ActivateWorkflow extends AbstractFixture implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function load(ObjectManager $manager)
    {
        $workflowManager = $this->container->get('oro_workflow.manager.system');

        if ($workflowManager->isActiveWorkflow('opportunity_flow')) {
            $workflowManager->deactivateWorkflow('opportunity_flow');
        }

        $workflowManager->activateWorkflow('custom_opportunity_flow');
    }
}
