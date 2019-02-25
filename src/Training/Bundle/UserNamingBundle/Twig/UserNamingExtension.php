<?php

namespace Training\Bundle\UserNamingBundle\Twig;

use Training\Bundle\UserNamingBundle\Provider\UserFullNameProvider;

class UserNamingExtension extends \Twig_Extension
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
            new \Twig_SimpleFilter('full_name_example', [$this->fullNameProvider, 'getFullNameExample'])
        ];
    }
}
