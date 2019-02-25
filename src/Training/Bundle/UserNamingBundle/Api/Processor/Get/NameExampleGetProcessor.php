<?php

namespace Training\Bundle\UserNamingBundle\Api\Processor\Get;

use Oro\Bundle\ApiBundle\Processor\Get\GetContext;
use Oro\Component\ChainProcessor\ContextInterface;
use Oro\Component\ChainProcessor\ProcessorInterface;
use Training\Bundle\UserNamingBundle\Provider\UserFullNameProvider;

class NameExampleGetProcessor implements ProcessorInterface
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
    public function process(ContextInterface $context)
    {
        /** @var GetContext $context */

        $result = $context->getResult();

        if (is_array($result)
            && array_key_exists('example', $result)
            && !array_key_exists('nameExample', $result)
        ) {
            $result['nameExample'] = $result['example'];
        }

        $context->setResult($result);
    }
}
