<?php

namespace AppBundle\Service;

use AppBundle\Entity\Account;
use AppBundle\Entity\Message;

/**
 * MailCollectorService.
 *
 * @author Florian Weber <florian.weber.dd@icloud.com>
 */
class MailCollectorService
{
    protected $doctrine;
    protected $user;

    /**
     * @var string The Nylas Messages Endpoint
     */
    protected $messageEndpoint;

    /**
     * @var GuzzleHttp\Client
     */
    protected $guzzleClient;

    public function __construct($doctrine, $tokenStorage, $messageEndpoint, $guzzleClient)
    {
        $this->doctrine = $doctrine;
        $this->user = $tokenStorage->getToken()->getUser();
        $this->messageEndpoint = $messageEndpoint;
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * Collects mail from one Account and one given Inbox.
     *
     * @param Account $account
     * @param string  $box
     */
    public function collectMail(Account $account, $box = 'inbox')
    {
        $em = $this->doctrine->getManager();

        //delete old emails
        $oldMessages = $this->doctrine->getRepository('AppBundle:Message')->findBy([
            'inbox' => $box,
            'user' => $this->user,
            'account' => $account,
        ]);

        foreach ($oldMessages as $om) {
            $em->remove($om);
        }

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

        //persist
        $this->persistMessages($parsed, $em, (string) $_response->getBody(), $account, $box);

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

        //delete old emails
        $oldMessages = $this->doctrine->getRepository('AppBundle:Message')->findBy([
            'inbox' => $box,
            'user' => $this->user,
        ]);

        $em = $this->doctrine->getManager();

        foreach ($oldMessages as $om) {
            $em->remove($om);
        }

        foreach ($accounts as $account) {
            $_response = $this->guzzleClient->request('GET', $url, [
                'auth' => [$account->getAccessToken(), null],
                'verify' => false,
            ]);

            $messages = json_decode((string) $_response->getBody());

            //persist
            $this->persistMessages($messages, $em, (string) $_response->getBody(), $account, $box);
        }

        $em->flush();
    }

    /**
     * Generates Message objects and calls the em persist on them.
     *
     * @param \stdClass $parsed
     * @param $em
     */
    protected function persistMessages($parsed, $em, $originalJson, $account, $box)
    {
        foreach ($parsed as $_message) {
            $message = new Message();
            $message
                ->setMessageId($_message->id)
                ->setSubject($_message->subject)
                ->setFromName($_message->from[0]->name)
                ->setFromEmail($_message->from[0]->email)
                ->setReceiver($this->flattenMailPersons($_message->to))
                ->setCc($this->flattenMailPersons($_message->cc))
                ->setBcc($this->flattenMailPersons($_message->bcc))
                ->setReplyTo($this->flattenMailPersons($_message->reply_to))
                ->setReceiveDate((new \DateTime())->setTimestamp($_message->date))
                ->setUnread($_message->unread)
                ->setStarred($_message->starred)
                ->setSnippet($_message->snippet)
                ->setBody($_message->body)
                ->setOriginalJson($originalJson)
                ->setAccount($account)
                ->setInbox($box)
                ->setUser($this->user)
            ;

            $em->persist($message);
        }
    }

    /**
     * Flattens a mail person object from the nylas response (to, cc, bcc, reply_to, ...) to a string
     * pattern: <person:name>|<person:email>;...
     *
     * @param \stdClass $persons
     *
     * @return string
     */
    protected function flattenMailPersons($persons)
    {
        if (count($persons) == 0) {
            return;
        }

        $flat = [];

        foreach ($persons as $person) {
            $flat[] = $person->name.'|'.$person->email;
        }

        return implode(';', $flat);
    }
}
