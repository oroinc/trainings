<?php

namespace Acme\Bundle\FrontendDashboardsBundle\Controller\Frontend;

use Acme\Bundle\FrontendDashboardsBundle\Provider\DTO\UserStat;
use Acme\Bundle\FrontendDashboardsBundle\Provider\UserStatsProviderInterface;
use Oro\Bundle\CustomerBundle\Entity\Customer;
use Oro\Bundle\CustomerBundle\Entity\CustomerUser;
use Oro\Bundle\LayoutBundle\Attribute\Layout;
use Oro\Bundle\SecurityBundle\Attribute\AclAncestor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route(path: '/', name: 'acme_frontend_dashboards_dashboard_index')]
    #[Layout]
    #[AclAncestor('oro_customer_frontend_customer_user_view')]
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
