<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * PageController
 *
 * @author Florian Weber <florian.weber.de@icloud.com>
 */
class PageController extends Controller
{
    public function dashboardAction()
    {
        return $this->render('Page/dashboard.html.twig');
    }
}
