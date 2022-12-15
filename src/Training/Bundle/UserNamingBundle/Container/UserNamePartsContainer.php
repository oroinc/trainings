<?php

namespace Training\Bundle\UserNamingBundle\Container;

use Oro\Bundle\UserBundle\Entity\User;

class UserNamePartsContainer
{
    public function getParts(User $user): array
    {
        return [
            'PREFIX' => $user->getNamePrefix(),
            'FIRST' => $user->getFirstName(),
            'MIDDLE' => $user->getMiddleName(),
            'LAST' => $user->getLastName(),
            'SUFFIX' => $user->getNameSuffix(),
        ];
    }
}
