<?php

namespace Training\Bundle\UserNamingBundle\Controller;

use Oro\Bundle\DashboardBundle\Model\WidgetConfigs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

class UserNamingController extends AbstractController
{
    /**
     * @Route("/", name="training_user_naming_index")
     * @Template
     * @AclAncestor("training_user_naming_view")
     *
     * @return array
     */
    public function indexAction()
    {
        return [
            'entity_class' => UserNamingType::class,
        ];
    }

    /**
     * @Route("/view/{id}", name="training_user_naming_view", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     *      id="training_user_naming_view",
     *      type="entity",
     *      class="TrainingUserNamingBundle:UserNamingType",
     *      permission="VIEW"
     * )
     *
     * @param UserNamingType $type
     * @return array
     */
    public function viewAction(UserNamingType $type)
    {
        return [
            'entity' => $type,
        ];
    }

    /**
     * @Route("/dashboard/user-information", name="training_user_dashboard_user_information", options={"expose"=true})
     * @Template
     * @param WidgetConfigs $widgetConfigs
     * @return array
     */
    public function dashboardUserInformationAction(WidgetConfigs $widgetConfigs)
    {
        $data = $widgetConfigs->getWidgetAttributesForTwig('current_user_information');
        $data['currentUser'] = $this->getUser();
        return $data;
    }
}
