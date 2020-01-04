<?php
/**
 * Call.php
 * Created by: nick
 * @ 22/12/2019 2:54 pm
 * Project: crm
 *
 * Copyright © 2019 Total Business Information Solutions Pty Ltd
 *
 */


namespace App\Entity\Crm;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Calls
 * @package App\Entity\Crm
 * @ORM\Entity()
 * @ORM\Table("calls")
 */
class Call
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
     * @ORM\Column(name="start_time",type="datetime")
     */
    private $startTime;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Crm\Contact")
     * @ORM\JoinColumn(referencedColumnName="id")*
     */
    private $contact;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Crm\Business")
     * @ORM\JoinColumn(referencedColumnName="id")*
     */
    private $business;

    /**
     * @ORM\Column()
     */
    private $status;

    /**
     * @ORM\OneToOne(targetEntity="Note")
     * @ORM\JoinColumn(name="notes", referencedColumnName="id")
     */
    private $notes;

}