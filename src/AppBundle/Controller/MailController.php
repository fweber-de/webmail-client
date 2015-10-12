<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Seld\JsonLint\JsonParser;
use GuzzleHttp\Client;

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
        $client = new Client();
        $parser = new JsonParser();

        if (!$accountId) {
            $accounts = $this->getDoctrine()->getRepository('AppBundle:Account')->findByUser($this->getUser());

            foreach ($accounts as $account) {
                $_response = $client->request('GET', 'https://api.nylas.com/messages?in=inbox', [
                    'auth' => [$account->getAccessToken(), null],
                    'verify' => false,
                ]);

                $messages = json_decode((string) $_response->getBody());

                foreach ($messages as $message) {
                    $elements[$message->date] = $message;
                }
            }

            krsort($elements);
        } else {
            $account = $this->getDoctrine()->getRepository('AppBundle:Account')->findOneByAccountId($accountId);
            $_response = $client->request('GET', 'https://api.nylas.com/messages?in=inbox', [
                'auth' => [$account->getAccessToken(), null],
                'verify' => false,
            ]);

            $elements = json_decode((string) $_response->getBody());
        }

        return $this->render('Mail/_elements.html.twig', [
            'elements' => $elements,
        ]);
    }
}
