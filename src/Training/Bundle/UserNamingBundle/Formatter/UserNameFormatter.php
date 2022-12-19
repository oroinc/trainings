<?php

namespace Training\Bundle\UserNamingBundle\Formatter;

use Oro\Bundle\UserBundle\Entity\User;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;
use Training\Bundle\UserNamingBundle\Provider\UserNamePartsProvider;

/**
 * Replaces placeholder parts with real User fields according to provided format
 */
class UserNameFormatter
{
    private UserNamePartsProvider $userNamePartsProvider;

    public function __construct(UserNamePartsProvider $userNamePartsProvider)
    {
        $this->userNamePartsProvider = $userNamePartsProvider;
    }

    /**
     * @param User $user
     * @param UserNamingType $format
     * @return string
     */
    public function format(User $user, UserNamingType $format): string
    {
        $replacements = $this->userNamePartsProvider->getParts($user);

        return strtr($format->getFormat(), $replacements);
    }
}
