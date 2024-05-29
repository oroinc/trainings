<?php

namespace TC\Bundle\UserBundle\Helper;

use Oro\Bundle\UserBundle\Entity\User;

class UserNameHelper
{
    public function getFullNameExtended(User $user): string
    {
        $nameParts = [
            $user->getNamePrefix(),
            $user->getFirstName(),
            $user->getMiddleName(),
            $user->getLastName(),
            $user->getNameSuffix(),
        ];

        $nameParts = array_filter($nameParts);

        return implode(' ', $nameParts);
    }
}
