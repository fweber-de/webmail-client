<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message.
 *
 * @ORM\Table("message")
 * @ORM\Entity
 */
class Message
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="message_id", type="string", length=255)
     */
    private $messageId;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="from_name", type="string", length=255)
     */
    private $fromName;

    /**
     * @var string
     *
     * @ORM\Column(name="from_email", type="string", length=255)
     */
    private $fromEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="receiver", type="string", length=255)
     */
    private $receiver;

    /**
     * @var string
     *
     * @ORM\Column(name="cc", type="string", length=255)
     */
    private $cc;

    /**
     * @var string
     *
     * @ORM\Column(name="bcc", type="string", length=255)
     */
    private $bcc;

    /**
     * @var string
     *
     * @ORM\Column(name="reply_to", type="string", length=255)
     */
    private $replyTo;

    /**
     * @var string
     *
     * @ORM\Column(name="receive_date", type="string", length=255)
     */
    private $receiveDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="unread", type="boolean")
     */
    private $unread;

    /**
     * @var bool
     *
     * @ORM\Column(name="starred", type="boolean")
     */
    private $starred;

    /**
     * @var string
     *
     * @ORM\Column(name="snippet", type="string", length=255)
     */
    private $snippet;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="original_json", type="text")
     */
    private $originalJson;

    /**
     * @ORM\ManyToOne(targetEntity="Account", inversedBy="messages")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $account;

    /**
     * @var string
     *
     * @ORM\Column(name="inbox", type="string", length=255)
     */
    private $inbox;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set messageId.
     *
     * @param string $messageId
     *
     * @return Message
     */
    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;

        return $this;
    }

    /**
     * Get messageId.
     *
     * @return string
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * Set subject.
     *
     * @param string $subject
     *
     * @return Message
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set fromName.
     *
     * @param string $fromName
     *
     * @return Message
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * Get fromName.
     *
     * @return string
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * Set fromEmail.
     *
     * @param string $fromEmail
     *
     * @return Message
     */
    public function setFromEmail($fromEmail)
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    /**
     * Get fromEmail.
     *
     * @return string
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    /**
     * Set receiver.
     *
     * @param string $receiver
     *
     * @return Message
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * Get receiver.
     *
     * @return string
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * Set cc.
     *
     * @param string $cc
     *
     * @return Message
     */
    public function setCc($cc)
    {
        $this->cc = $cc;

        return $this;
    }

    /**
     * Get cc.
     *
     * @return string
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * Set bcc.
     *
     * @param string $bcc
     *
     * @return Message
     */
    public function setBcc($bcc)
    {
        $this->bcc = $bcc;

        return $this;
    }

    /**
     * Get bcc.
     *
     * @return string
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * Set replyTo.
     *
     * @param string $replyTo
     *
     * @return Message
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;

        return $this;
    }

    /**
     * Get replyTo.
     *
     * @return string
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * Set receiveDate.
     *
     * @param string $receiveDate
     *
     * @return Message
     */
    public function setReceiveDate($receiveDate)
    {
        $this->receiveDate = $receiveDate;

        return $this;
    }

    /**
     * Get receiveDate.
     *
     * @return string
     */
    public function getReceiveDate()
    {
        return $this->receiveDate;
    }

    /**
     * Set unread.
     *
     * @param bool $unread
     *
     * @return Message
     */
    public function setUnread($unread)
    {
        $this->unread = $unread;

        return $this;
    }

    /**
     * Get unread.
     *
     * @return bool
     */
    public function getUnread()
    {
        return $this->unread;
    }

    /**
     * Set starred.
     *
     * @param bool $starred
     *
     * @return Message
     */
    public function setStarred($starred)
    {
        $this->starred = $starred;

        return $this;
    }

    /**
     * Get starred.
     *
     * @return bool
     */
    public function getStarred()
    {
        return $this->starred;
    }

    /**
     * Set snippet.
     *
     * @param string $snippet
     *
     * @return Message
     */
    public function setSnippet($snippet)
    {
        $this->snippet = $snippet;

        return $this;
    }

    /**
     * Get snippet.
     *
     * @return string
     */
    public function getSnippet()
    {
        return $this->snippet;
    }

    /**
     * Set body.
     *
     * @param string $body
     *
     * @return Message
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set originalJson.
     *
     * @param string $originalJson
     *
     * @return Message
     */
    public function setOriginalJson($originalJson)
    {
        $this->originalJson = $originalJson;

        return $this;
    }

    /**
     * Get originalJson.
     *
     * @return string
     */
    public function getOriginalJson()
    {
        return $this->originalJson;
    }

    /**
     * Set account.
     *
     * @param \AppBundle\Entity\Account $account
     *
     * @return Message
     */
    public function setAccount(\AppBundle\Entity\Account $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account.
     *
     * @return \AppBundle\Entity\Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set inbox.
     *
     * @param string $inbox
     *
     * @return Message
     */
    public function setInbox($inbox)
    {
        $this->inbox = $inbox;

        return $this;
    }

    /**
     * Get inbox.
     *
     * @return string
     */
    public function getInbox()
    {
        return $this->inbox;
    }
}
