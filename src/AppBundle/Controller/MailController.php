<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * MailController.
 *
 * @author Florian Weber <florian.weber.de@icloud.com>
 */
class MailController extends Controller
{
    public function inboxAction()
    {
        return $this->render('Mail/inbox.html.twig');
    }

    public function sidebarAction()
    {
        $accounts = [];

        return $this->render('Mail/_sidebar.html.twig', [
            'accounts' => $accounts,
        ]);
    }
}
