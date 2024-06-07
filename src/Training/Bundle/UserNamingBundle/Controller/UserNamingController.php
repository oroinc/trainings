<?php

namespace Training\Bundle\UserNamingBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

class UserNamingController
{
    #[Route(path: '/', name: 'training_user_naming_index')]
    #[Template]
    public function indexAction(): array
    {
        return [
            'entity_class' => UserNamingType::class,
        ];
    }
}
