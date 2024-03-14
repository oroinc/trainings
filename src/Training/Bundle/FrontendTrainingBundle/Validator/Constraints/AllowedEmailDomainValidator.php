<?php

namespace Training\Bundle\FrontendTrainingBundle\Validator\Constraints;

use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AllowedEmailDomainValidator extends ConstraintValidator
{
    public function __construct(private readonly ConfigManager $configManager)
    {
    }

    public function validate($value, Constraint $constraint): void
    {
        $allowedDomain = $this->configManager->get('training_frontend_training.allowed_email_domain');

        if ($allowedDomain === null) {
            return;
        }

        # check if value is from defined domain using regex
        if (!preg_match('/^([a-zA-Z0-9._%-]+)@' . $allowedDomain . '$/', $value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ allowed_email_domain }}', $allowedDomain)
                ->addViolation();
        }
    }
}
