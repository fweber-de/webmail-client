<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Account.
 *
 * @ORM\Table("account")
 * @ORM\Entity
 */
class Account
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
     * @ORM\Column(name="access_token", type="string", length=255)
     */
    private $accessToken;

    /**
     * @var string
     *
     * @ORM\Column(name="email_address", type="string", length=255)
     */
    private $emailAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="provider", type="string", length=255)
     */
    private $provider;

    /**
     * @var string
     *
     * @ORM\Column(name="account_id", type="string", length=255)
     */
    private $accountId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="open_date", type="datetime")
     */
    private $openDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="edit_date", type="datetime", nullable=true)
     */
    private $editDate;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="accounts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="short_name", type="string", length=255, nullable=true)
     */
    private $shortName;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="account")
     */
    private $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

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
     * Set accessToken.
     *
     * @param string $accessToken
     *
     * @return Account
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Get accessToken.
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set emailAddress.
     *
     * @param string $emailAddress
     *
     * @return Account
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * Get emailAddress.
     *
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Set provider.
     *
     * @param string $provider
     *
     * @return Account
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider.
     *
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set accountId.
     *
     * @param string $accountId
     *
     * @return Account
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;

        return $this;
    }

    /**
     * Get accountId.
     *
     * @return string
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set openDate.
     *
     * @param \DateTime $openDate
     *
     * @return Account
     */
    public function setOpenDate($openDate)
    {
        $this->openDate = $openDate;

        return $this;
    }

    /**
     * Get openDate.
     *
     * @return \DateTime
     */
    public function getOpenDate()
    {
        return $this->openDate;
    }

    /**
     * Set editDate.
     *
     * @param \DateTime $editDate
     *
     * @return Account
     */
    public function setEditDate($editDate)
    {
        $this->editDate = $editDate;

        return $this;
    }

    /**
     * Get editDate.
     *
     * @return \DateTime
     */
    public function getEditDate()
    {
        return $this->editDate;
    }

    /**
     * Set user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Account
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set shortName.
     *
     * @param string $shortName
     *
     * @return Account
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * Get shortName.
     *
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * Add message.
     *
     * @param \AppBundle\Entity\Messages $message
     *
     * @return Account
     */
    public function addMessage(\AppBundle\Entity\Messages $message)
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Remove message.
     *
     * @param \AppBundle\Entity\Messages $message
     */
    public function removeMessage(\AppBundle\Entity\Messages $message)
    {
        $this->messages->removeElement($message);
    }

    /**
     * Get messages.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
