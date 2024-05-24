<?php

namespace TC\Bundle\ConfigBundle\Twig;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ParamentersExtension extends AbstractExtension
{
    public function __construct(protected ParameterBagInterface $params)
    {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('get_parameter_value', [$this, 'getParameterValue']),
        ];
    }

    public function getParameterValue(string $parameterName)
    {
        return $this->params->get($parameterName);
    }
}
