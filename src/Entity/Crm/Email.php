<?php
/**
 * Email.php
 * Created by: nick
 * @ 17/12/2019 10:27 AM
 * Project: crm_business
 *
 * Copyright © 2019 Total Business Information Solutions Pty Ltd
 *
 */


namespace App\Entity\Crm;

use App\Entity\BaseObject;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Email
 * @package App\Entity\Crm
 * @ORM\Entity()
 * @ORM\Table("emails")
 */
class Email
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

/**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime",columnDefinition="TIMESTAMP ON UPDATE CURRENT_TIMESTAMP")
     */
    protected $updated;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Crm\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    protected $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Crm\User")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id")*
     */
    protected $updatedBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person")
     * @ORM\JoinColumn(name="sender", referencedColumnName="id")*
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person")
     * @ORM\JoinColumn(name="recipient", referencedColumnName="id")*
     */
    private $recipient;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Person")
     * @ORM\JoinTable(name="email_ccs",
     *      joinColumns={@ORM\JoinColumn(name="email_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")}
     *      )
     */
    private $ccs;

    /**
     * @ORM\Column(length=255)
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Crm\Note")
     * @ORM\JoinTable(name="email_notes",
     *      joinColumns={@ORM\JoinColumn(name="email_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="note_id", referencedColumnName="id")}
     *      )
     */
    private $notes;
}