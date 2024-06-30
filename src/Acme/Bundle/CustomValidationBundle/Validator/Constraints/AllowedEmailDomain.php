<?php

namespace Acme\Bundle\CustomValidationBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class AllowedEmailDomain extends Constraint
{
    public string $message = 'acme.custom_validation.allowed_email_domain.message';
}
