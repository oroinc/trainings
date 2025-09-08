<?php

namespace Webinar\Bundle\ReactBundle\Controller\Frontend;

use Oro\Bundle\LayoutBundle\Attribute\Layout;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class ReactController extends AbstractController
{
    #[Route(path: '/', name: 'orolab_react_index')]
    #[Layout()]
    public function indexAction(): array
    {
        return [];
    }
}
