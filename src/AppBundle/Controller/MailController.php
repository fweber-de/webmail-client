<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
            $elements = $this->getDoctrine()->getRepository('AppBundle:Message')->findBy([
                'user' => $this->getUser(),
                'inbox' => 'inbox',
            ], [
                'receiveDate' => 'desc',
            ]);
        } else {
            $account = $this->getDoctrine()->getRepository('AppBundle:Account')->findOneByAccountId($accountId);
            $elements = $this->getDoctrine()->getRepository('AppBundle:Message')->findBy([
                'account' => $account,
                'inbox' => 'inbox',
            ], [
                'receiveDate' => 'desc',
            ]);
        }

        return $this->render('Mail/_elements.html.twig', [
            'elements' => $elements,
        ]);
    }

    /**
     * JSON ENDPOINT.
     *
     * @param int $messageId
     *
     * @return Reponse
     */
    public function getMessageAction($messageId)
    {
        $message = $this->getDoctrine()->getRepository('AppBundle:Message')->findOneById($messageId);

        $jsonContent = $this->get('serializer')->serialize($message, 'json');

        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * JSON ENDPOINT.
     */
    public function refreshInboxAction(Request $request)
    {
        $inbox = $request->get('inbox', null);

        if ($inbox == null) {
            throw new \Exception('Parameter inbox is required!');
        }

        if ($request->get('accountId', null) == null) {
            $this->get('app.mail_collector')->collectAllMail($inbox);
        } else {
            $account = $this->getDoctrine()->getRepository('AppBundle:Account')->findOneByAccountId($accountId);
            $this->get('app.mail_collector')->collectMail($account, $inbox);
        }

        $response = new Response(json_encode(true));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
