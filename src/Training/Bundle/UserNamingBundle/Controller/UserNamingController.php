<?php

namespace Training\Bundle\UserNamingBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

class UserNamingController
{
    /**
     * @Route("/", name="training_user_naming_index")
     * @Template
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
}
