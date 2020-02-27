<?php
/**
 * Job.php
 * Created by: nick
 * @ 17/12/2019 9:06 AM
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
 * Class Job
 * @package App\Entity\Crm
 * @ORM\Entity()
 * @ORM\Table("jobs")
 */
class Job
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
     * @ORM\Column(length=255,nullable=true)
     */
    private $jobId;

    /**
     * @ORM\Column(length=255,nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(length=255,nullable=true)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Crm\Lead")
     * @ORM\JoinColumn(name="lead", referencedColumnName="id",onDelete="SET NULL")
     */
    protected $lead;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Crm\Quote")
     * @ORM\JoinColumn(name="quote", referencedColumnName="id",onDelete="SET NULL")
     */
    protected $quote;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Crm\Business")
     * @ORM\JoinColumn(name="business", referencedColumnName="id",onDelete="SET NULL")
     */
    protected $business;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Crm\Note")
     * @ORM\JoinTable(name="job_notes",
     *      joinColumns={@ORM\JoinColumn(name="job",referencedColumnName="id",onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="note",referencedColumnName="id",unique=true,onDelete="CASCADE")}
     * )
     */
    private $notes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Event")
     * @ORM\JoinTable(name="job_events",
     *      joinColumns={@ORM\JoinColumn(name="job",referencedColumnName="id",onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="event",referencedColumnName="id",unique=true,onDelete="CASCADE")}
     * )
     */
    private $events;

    /**
     * @ORM\Column(type="date",nullable=true,options={"default" : NULL})
     */
    private $deliveryDate;

    /**
     * @ORM\Column(type="datetime",nullable=true,options={"default" : NULL})
     */
    private $completedDate;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDeliveryDate()
    {
        return $this->deliveryDate;
    }

    /**
     * @param mixed $deliveryDate
     */
    public function setDeliveryDate($deliveryDate): void
    {
        $this->deliveryDate = $deliveryDate;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created): void
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated($updated): void
    {
        $this->updated = $updated;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $createdBy
     */
    public function setCreatedBy($createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return mixed
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @param mixed $updatedBy
     */
    public function setUpdatedBy($updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param mixed $notes
     */
    public function setNotes($notes): void
    {
        $this->notes = $notes;
    }

    /**
     * @param $note
     */
    public function addNote($note): void
    {
        $this->notes[] = $note;
    }

    /**
     * @return mixed
     */
    public function getBusiness()
    {
        return $this->business;
    }

    /**
     * @param mixed $business
     */
    public function setBusiness($business): void
    {
        $this->business = $business;
    }

    /**
     * @return mixed
     */
    public function getJobId()
    {
        return $this->jobId;
    }

    /**
     * @param mixed $jobId
     */
    public function setJobId($jobId): void
    {
        $this->jobId = $jobId;
    }

    /**
     * @return mixed
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param mixed $events
     */
    public function setEvents($events): void
    {
        $this->events = $events;
    }

    /**
     * @param $event
     */
    public function addEvent($event){
        $this->events[] = $event;
    }

    /**
     * @return mixed
     */
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * @param mixed $quote
     */
    public function setQuote($quote): void
    {
        $this->quote = $quote;
    }

    /**
     * @return mixed
     */
    public function getCompletedDate()
    {
        return $this->completedDate;
    }

    /**
     * @param mixed $completedDate
     */
    public function setCompletedDate($completedDate): void
    {
        $this->completedDate = $completedDate;
    }

    /**
     * @return mixed
     */
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * @param mixed $lead
     */
    public function setLead($lead): void
    {
        $this->lead = $lead;
    }



}
