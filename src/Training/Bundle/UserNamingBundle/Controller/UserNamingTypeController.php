<?php

namespace Training\Bundle\UserNamingBundle\Controller;

use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

/**
 * CRUD for user naming type.
 */
class UserNamingTypeController extends AbstractController
{
    /**
     * Represents index page for UserNamingType Entity
     * @Route(
     *     "/{_format}",
     *      name="training_user_naming_type_index",
     *      requirements={"_format"="html"},
     *      defaults={"_format" = "html"}
     * )
     * @AclAncestor("training_user_naming_view")
     *
     * @Template
     *
     * @param Request $request
     * @return string[]
     */
    public function indexAction(Request $request): array
    {
        return [
            'entity_class' => UserNamingType::class
        ];
    }

    /**
     * Adds view page for UserNamingType Entity
     *
     * @Route(
     *     "/view/{id}",
     *     name="training_user_naming_type_view",
     *     requirements={"id"="\d+"}
     * )
     *
     * @Acl(
     *      id="training_user_naming_view",
     *      type="entity",
     *      permission="VIEW",
     *      class="TrainingUserNamingBundle:UserNamingType"
     * )
     *
     * @Template("@TrainingUserNaming/UserNamingType/view.html.twig")
     *
     * @param UserNamingType $userNamingType
     * @return UserNamingType[]
     */
    public function viewAction(UserNamingType $userNamingType): array
    {
        return [
            'entity' => $userNamingType
        ];
    }
}
