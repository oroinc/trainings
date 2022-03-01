<?php

namespace Training\Bundle\CheckoutBundle\Migrations\Data\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class ActivateCheckoutWorkflow extends AbstractFixture implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $workflowManager = $this->container->get('oro_workflow.manager');
        $workflowManager->deactivateWorkflow('b2b_flow_checkout');
        $workflowManager->activateWorkflow('training_b2b_flow_checkout');
    }
}
