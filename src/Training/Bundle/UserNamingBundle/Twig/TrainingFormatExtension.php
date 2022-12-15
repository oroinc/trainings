<?php

namespace Training\Bundle\UserNamingBundle\Twig;

use Oro\Bundle\UserBundle\Entity\User;
use Training\Bundle\UserNamingBundle\Formatter\UserNameFormatter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TrainingFormatExtension extends AbstractExtension
{
    private UserNameFormatter $nameFormatter;

    public function __construct(UserNameFormatter $nameFormatter)
    {
        $this->nameFormatter = $nameFormatter;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('training_format_user_naming', [$this, 'formatUserNaming']),
        ];
    }

    public function formatUserNaming(User $user, string $namingType): string
    {
        return $this->nameFormatter->format($user, $namingType);
    }
}