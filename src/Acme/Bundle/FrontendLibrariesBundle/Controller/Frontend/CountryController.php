<?php

namespace Acme\Bundle\FrontendLibrariesBundle\Controller\Frontend;

use Oro\Bundle\LayoutBundle\Attribute\Layout;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CountryController extends AbstractController
{
    #[Route(path: '/', name: 'acme_frontend_libraries_country_index')]
    #[Layout]
    public function indexAction(): array
    {
        return [];
    }
}
