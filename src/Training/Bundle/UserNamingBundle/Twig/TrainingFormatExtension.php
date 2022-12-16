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
            new TwigFilter('training_example_user_naming', [$this, 'getExampleForUserNaming']),
        ];
    }

    public function getExampleForUserNaming(string $format): string
    {
        $user = new User();

        $user->setNamePrefix('Mr.')
            ->setFirstName('John')
            ->setMiddleName('M')
            ->setLastName('Doe')
            ->setNameSuffix('Jr.');

        return $this->nameFormatter->format($user, $format);
    }
}