<?php

namespace Training\Bundle\UserNamingBundle\Controller;

use Oro\Bundle\SecurityBundle\Attribute\Acl;
use Oro\Bundle\SecurityBundle\Attribute\AclAncestor;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

class UserNamingController
{
    #[Route(path: '/', name: 'training_user_naming_index')]
    #[Template]
    #[AclAncestor('training_user_naming_view')]
    public function indexAction(): array
    {
        return [
            'entity_class' => UserNamingType::class,
        ];
    }

    /**
     * @param UserNamingType $type
     * @return array
     */
    #[Route(path: '/view/{id}', name: 'training_user_naming_view', requirements: ['id' => '\d+'])]
    #[Template]
    #[Acl(id: 'training_user_naming_view', type: 'entity', class: UserNamingType::class, permission: 'VIEW')]
    public function viewAction(UserNamingType $type): array
    {
        return [
            'entity' => $type,
        ];
    }
}
