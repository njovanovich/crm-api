<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 24/05/2019
 * Time: 9:14 PM
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Message
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table("messages")
 */
class Message extends BaseObject
{
    /**
     * @ORM\OneToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="sender", referencedColumnName="id")
     */
    private $sender;

    /**
     * @ORM\OneToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="recipient", referencedColumnName="id")
     */
    private $recipient;

    /**
     * @ORM\Column(length=20)
     */
    private $protocol;

    /**
     * @ORM\OneToOne(targetEntity="Document")
     * @ORM\JoinColumn(name="document", referencedColumnName="id")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $sent;

    /**
     * @ORM\Column(type="datetime")
     */
    private $received;

    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param mixed $sender
     */
    public function setSender($sender): void
    {
        $this->sender = $sender;
    }

    /**
     * @return mixed
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param mixed $recipient
     */
    public function setRecipient($recipient): void
    {
        $this->recipient = $recipient;
    }

    /**
     * @return mixed
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @param mixed $protocol
     */
    public function setProtocol($protocol): void
    {
        $this->protocol = $protocol;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getSent()
    {
        return $this->sent;
    }

    /**
     * @param mixed $sent
     */
    public function setSent($sent): void
    {
        $this->sent = $sent;
    }

    /**
     * @return mixed
     */
    public function getReceived()
    {
        return $this->received;
    }

    /**
     * @param mixed $received
     */
    public function setReceived($received): void
    {
        $this->received = $received;
    }


}