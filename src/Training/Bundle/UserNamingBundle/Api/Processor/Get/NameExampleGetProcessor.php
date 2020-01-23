<?php

namespace Training\Bundle\UserNamingBundle\Api\Processor\Get;

use Oro\Bundle\ApiBundle\Processor\Get\GetContext;
use Oro\Component\ChainProcessor\ContextInterface;
use Oro\Component\ChainProcessor\ProcessorInterface;

class NameExampleGetProcessor implements ProcessorInterface
{
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
