<?php

namespace Demo\Bundle\OrderBundle\Placeholder;

use Symfony\Component\HttpFoundation\RequestStack;

class PlaceholderFilter
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function isRoute(string $route): bool
    {
        $request = $this->requestStack->getCurrentRequest();

        return $request->attributes->get('_route') === $route;
    }
}
