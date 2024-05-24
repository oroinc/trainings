<?php

namespace TC\Bundle\UserBundle\Async\Topics;

use Oro\Component\MessageQueue\Topic\AbstractTopic;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenerateUserFullNameExtendedTopic extends AbstractTopic
{
    public static function getName(): string
    {
        return 'tc_user.generate_full_name_extended';
    }

    public static function getDescription(): string
    {
        return 'Generates full name from all 5 name parts for User.';
    }

    public function configureMessageBody(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired(['id'])
            ->addAllowedTypes('id', 'int');
    }
}
