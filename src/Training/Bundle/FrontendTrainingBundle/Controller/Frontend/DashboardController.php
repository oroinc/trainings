<?php

namespace Training\Bundle\FrontendTrainingBundle\Controller\Frontend;

use Oro\Bundle\CustomerBundle\Entity\Customer;
use Oro\Bundle\CustomerBundle\Entity\CustomerUser;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Oro\Bundle\LayoutBundle\Annotation\Layout;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Training\Bundle\FrontendTrainingBundle\Provider\DTO\UserStat;
use Training\Bundle\FrontendTrainingBundle\Provider\UserStatsProviderInterface;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="training_frontend_training_dashboard_index")
     * @Layout()
     * @AclAncestor("oro_customer_frontend_customer_user_view")
     */
    public function indexAction(): array
    {
        return [
            'data' => [
                'userStats' => [
                    'data' => array_map(function (UserStat $stat) {
                        return $stat->toArray();
                    }, $this->container->get(UserStatsProviderInterface::class)->getUserStats($this->getCustomer()))
                ]
            ]
        ];
    }

    private function getCustomer(): Customer
    {
        $customerUser = $this->container->get('security.token_storage')?->getToken()?->getUser();
        if ($customerUser instanceof CustomerUser) {
            return $customerUser->getCustomer();
        }

        throw new \LogicException('Current Customer not found!');
    }

    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            UserStatsProviderInterface::class
        ]);
    }
}
