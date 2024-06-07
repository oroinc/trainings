<?php

namespace TC\Bundle\CheckoutBundle\Migrations\Data\ORM;

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

        if ($workflowManager->isActiveWorkflow('b2b_flow_checkout')) {
            $workflowManager->deactivateWorkflow('b2b_flow_checkout');
        }

        $workflowManager->activateWorkflow('custom_b2b_flow_checkout');
    }
}
