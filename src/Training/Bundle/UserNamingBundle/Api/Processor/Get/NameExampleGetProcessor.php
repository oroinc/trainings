<?php

namespace Training\Bundle\UserNamingBundle\Api\Processor\Get;

use Oro\Bundle\ApiBundle\Processor\Get\GetContext;
use Oro\Component\ChainProcessor\ContextInterface;
use Oro\Component\ChainProcessor\ProcessorInterface;
use Training\Bundle\UserNamingBundle\Provider\UserFullNameProvider;

class NameExampleGetProcessor implements ProcessorInterface
{
    /**
     * @param UserFullNameProvider $fullNameProvider
     */
    public function __construct(private UserFullNameProvider $fullNameProvider)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContextInterface $context)
    {
        /** @var GetContext $context */

        $result = $context->getResult();

        if (is_array($result)
            && array_key_exists('format', $result)
            && !array_key_exists('nameExample', $result)
        ) {
            $result['nameExample'] = $this->fullNameProvider->getFullNameExample($result['format']);
        }

        $context->setResult($result);
    }
}
