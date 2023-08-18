<?php

namespace Training\Bundle\UserNamingBundle\Async\Topics;

use Oro\Component\MessageQueue\Topic\AbstractTopic;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenerateNameExampleTopic extends AbstractTopic
{
    public static function getName(): string
    {
        return 'training_user_naming.generate_name_example';
    }

    public static function getDescription(): string
    {
        return 'Generates name example for UserNamingType.';
    }

    public function configureMessageBody(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired(['id'])
            ->addAllowedTypes('id', 'int');
    }
}
