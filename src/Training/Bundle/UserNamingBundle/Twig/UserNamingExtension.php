<?php

namespace Training\Bundle\UserNamingBundle\Twig;

use Training\Bundle\UserNamingBundle\Provider\UserFullNameProvider;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class UserNamingExtension extends AbstractExtension
{
    /** @var UserFullNameProvider */
    private $fullNameProvider;

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
    public function getFilters()
    {
        return [
            new TwigFilter('full_name_example', [$this->fullNameProvider, 'getFullNameExample'])
        ];
    }
}
