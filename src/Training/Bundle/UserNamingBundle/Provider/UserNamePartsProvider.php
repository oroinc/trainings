<?php

namespace Training\Bundle\UserNamingBundle\Provider;

use Oro\Bundle\UserBundle\Entity\User;

/**
 * Provides parts of the User Entity name that can be used for user naming
 */
class UserNamePartsProvider
{
    /**
     * @param User $user
     * @return array
     */
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
