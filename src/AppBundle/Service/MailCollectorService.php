<?php

namespace AppBundle\Service;

use AppBundle\Entity\Account;
use AppBundle\Entity\Message;
use GuzzleHttp\Client;

class MailCollectorService
{
    protected $doctrine;
    protected $user;
    protected $messageEndpoint;
    protected $guzzleClient;

    public function __construct($doctrine, $user, $messageEndpoint)
    {
        $this->db = $doctrine;
        $this->user = $user;
        $this->messageEndpoint = $messageEndpoint;

        $this->guzzleClient = new Client();
    }

    /**
     * Collects mail from one Account and one given Inbox.
     *
     * @param Account $account
     * @param string  $box
     */
    public function collectMail(Account $account, $box = 'inbox')
    {
        //request mail from nylas
        $url = $this->messageEndpoint.'?'.http_build_query([
            'in' => $box,
        ]);

        $_response = $this->guzzleClient->request('GET', $url, [
            'auth' => [$account->getAccessToken(), null],
            'verify' => false,
        ]);

        //parse string to object
        $parsed = json_decode((string) $_response->getBody());

        //delete old emails
        $oldMessages = $this->doctrine->getRepository('AppBundle:Message')->findBy([
            'inbox' => $box,
            'user' => $this->user,
            'account' => $account,
        ]);

        $em = $this->doctrine->getManager();
        $em->remove($oldMessages);

        //persist
        $this->persistMessages($parsed, $em);

        $em->flush();
    }

    /**
     * Collects mail from all Accounts and one given inbox.
     *
     * @param string $box
     */
    public function collectAllMail($box = 'inbox')
    {
        $accounts = $this->doctrine->getRepository('AppBundle:Account')->findByUser($this->user);
        $elements = [];
        $url = $this->messageEndpoint.'?'.http_build_query([
            'in' => $box,
        ]);

        foreach ($accounts as $account) {
            $_response = $this->guzzleClient->request('GET', $url, [
                'auth' => [$account->getAccessToken(), null],
                'verify' => false,
            ]);

            $messages = json_decode((string) $_response->getBody());

            foreach ($messages as $message) {
                $elements[] = $message;
            }
        }

        //delete old emails
        $oldMessages = $this->doctrine->getRepository('AppBundle:Message')->findBy([
            'inbox' => $box,
            'user' => $this->user,
        ]);

        $em = $this->doctrine->getManager();
        $em->remove($oldMessages);

        //persist
        $this->persistMessages($elements, $em);

        $em->flush();
    }

    /**
     * Generates Message objects and calls the em persist on them.
     *
     * @param \stdClass $parsed
     * @param $em
     */
    protected function persistMessages($parsed, $em)
    {
        foreach ($parsed as $_message) {
            $message = new Message();
            $message
                ->setMessageId($_message->message_id)
                ->setSubject($_message->subject)
                ->setFromName('')
                ->setFromEmail('')
                ->setReceiver('')
                ->setCc('')
                ->setBcc('')
                ->setReplyTo('')
                ->setReceiveDate(new \DateTime($_message->date))
                ->setUnread($_message->unread)
                ->setStarred($_message->starred)
                ->setSnippet($_message->snippet)
                ->setBody($_message->body)
                ->setOriginalJson((string) $_response->getBody())
                ->setAccount($account)
                ->setInbox($box)
            ;

            $em->persist($message);
        }
    }
}
