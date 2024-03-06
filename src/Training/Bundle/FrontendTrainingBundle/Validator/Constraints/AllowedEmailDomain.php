<?php

namespace Training\Bundle\FrontendTrainingBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class AllowedEmailDomain extends Constraint
{
    public $message = 'training.frontend_training.allowed_email_domain.message';
}
