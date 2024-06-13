<?php

namespace Training\Bundle\UserNamingBundle\Twig;

use Oro\Bundle\UserBundle\Entity\User;

use Training\Bundle\UserNamingBundle\Provider\UserFullNameProvider;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class UserNamingExtension extends AbstractExtension
{
    private UserFullNameProvider $fullNameProvider;

    /**
     * @param UserFullNameProvider $fullNameProvider
     */
    public function __construct(UserFullNameProvider $fullNameProvider)
    {
        $this->fullNameProvider = $fullNameProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('full_name_example', [$this->fullNameProvider, 'getFullNameExample'])
        ];
    }
}
