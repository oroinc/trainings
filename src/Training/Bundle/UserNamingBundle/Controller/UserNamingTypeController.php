<?php

namespace Training\Bundle\UserNamingBundle\Controller;

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
}