<?php

namespace Training\Bundle\UserNamingBundle\Twig;

use Oro\Bundle\UserBundle\Entity\User;

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
            new \Twig_SimpleFilter('full_name_example', [$this, 'getFullNameExample'])
        ];
    }

    /**
     * @param string $format
     * @return string
     */
    public function getFullNameExample($format)
    {
        $user = new User();
        $user->setNamePrefix('Mr.')
            ->setFirstName('John')
            ->setMiddleName('M')
            ->setLastName('Doe')
            ->setNameSuffix('Jr.');

        return $this->fullNameProvider->getFullName($user, $format);
    }
}
