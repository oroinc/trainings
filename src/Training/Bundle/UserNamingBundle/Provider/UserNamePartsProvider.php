<?php

namespace Training\Bundle\UserNamingBundle\Provider;

use Oro\Bundle\UserBundle\Entity\User;

class UserNamePartsProvider
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
