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
    public function unifiedInboxAction()
    {
        return $this->render('Mail/unified_inbox.html.twig');
    }

    public function accountInboxAction($accountId)
    {
        $account = $this->getDoctrine()->getRepository('AppBundle:Account')->findOneByAccountId($accountId);

        return $this->render('Mail/account_inbox.html.twig', [
            'account' => $account,
        ]);
    }

    public function sidebarAction()
    {
        $accounts = $this->getDoctrine()->getRepository('AppBundle:Account')->findByUser($this->getUser());

        return $this->render('Mail/_sidebar.html.twig', [
            'accounts' => $accounts,
        ]);
    }

    public function elementsAction($accountId)
    {
        $elements = [];

        if (!$accountId) {
            $accounts = $this->getDoctrine()->getRepository('AppBundle:Account')->findByUser($this->getUser());
        } else {
            $account = $this->getDoctrine()->getRepository('AppBundle:Account')->findOneByAccountId($accountId);
        }

        return $this->render('Mail/_elements.html.twig', [
            'elements' => $elements,
        ]);
    }
}
