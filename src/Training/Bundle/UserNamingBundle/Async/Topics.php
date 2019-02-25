<?php

namespace Training\Bundle\UserNamingBundle\Async;

class Topics
{
    /**
     * This topic is used to identify messages sent to generate name example at UserNamingType entity
     */
    const GENERATE_NAME_EXAMPLE = 'training_user_naming.generate_name_example';
}
