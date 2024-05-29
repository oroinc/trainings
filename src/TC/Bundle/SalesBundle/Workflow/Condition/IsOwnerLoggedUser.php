<?php

namespace TC\Bundle\SalesBundle\Workflow\Condition;

use Oro\Bundle\SecurityBundle\Authentication\TokenAccessorInterface;
use Oro\Component\Action\Condition\AbstractCondition;
use Oro\Component\ConfigExpression\ContextAccessorAwareInterface;
use Oro\Component\ConfigExpression\ContextAccessorAwareTrait;
use Symfony\Component\PropertyAccess\PropertyPath;

class IsOwnerLoggedUser extends AbstractCondition implements ContextAccessorAwareInterface
{
    use ContextAccessorAwareTrait;

    public const NAME = 'is_owner_logged_user';

    /** @var PropertyPath */
    private $owner;

    public function __construct(private TokenAccessorInterface $tokenAccessor)
    {
    }

    protected function isConditionAllowed($context): bool
    {
        $loggedUser = $this->tokenAccessor->getUser();
        $owner = $this->resolveValue($context, $this->owner);

        return get_class($loggedUser) === get_class($owner) && $loggedUser?->getId() == $owner?->getId();
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function initialize(array $options)
    {
        if (array_key_exists('owner', $options)) {
            $this->owner = $options['owner'];
        }

        return $this;
    }
}
