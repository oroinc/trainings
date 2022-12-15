<?php

namespace Training\Bundle\UserNamingBundle\Formatter;

use Oro\Bundle\UserBundle\Entity\User;
use Training\Bundle\UserNamingBundle\Container\UserNamePartsContainer;
use Training\Bundle\UserNamingBundle\Entity\UserNamingType;

/**
 * Replaces placeholder parts with real User fields according to provided format
 */
class UserNameFormatter
{
    private UserNamePartsContainer $userNamePartsContainer;

    public function __construct(UserNamePartsContainer $userNamePartsContainer)
    {
        $this->userNamePartsContainer = $userNamePartsContainer;
    }

    /**
     * @param User $user
     * @param UserNamingType $format
     * @return string
     */
    public function format(User $user, UserNamingType $format): string
    {
        $replacements = $this->userNamePartsContainer->getParts($user);

        return strtr($format->getFormat(), $replacements);
    }
}
