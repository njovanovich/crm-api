<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 24/05/2019
 * Time: 7:32 PM
 */

namespace App\Entity\Crm;

use App\Entity\Event;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Lead
 * @package App\Entity\Crm
 * @ORM\Entity()
 * @ORM\Table("leads")
 */
class Lead 
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime")
	 * @Gedmo\Timestampable(on="update")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Person",fetch="EAGER")
     * @ORM\JoinColumn(name="person", referencedColumnName="id")
     */
    private $person;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Crm\User")
     * @ORM\JoinColumn(name="owner", referencedColumnName="id")
     */
    private $owner;

    /**
     * @ORM\Column(nullable=true)
     */
    private $leadId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Crm\Business",fetch="EAGER")
     * @ORM\JoinColumn(name="business", referencedColumnName="id",nullable=true,onDelete="SET NULL")
     */
    private $business;

    /**
     * @ORM\Column(nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(name="lead_source",nullable=true)
     */
    private $leadSource;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $amount;

    /**
     * @ORM\Column(nullable=true)
     */
    private $campaign;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Crm\User")
     * @ORM\JoinColumn(name="assigned_to", referencedColumnName="id")
     */
    private $assignedTo;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Crm\Note")
     * @ORM\JoinTable(name="lead_notes",
     *     joinColumns={@ORM\JoinColumn(name="lead", referencedColumnName="id",onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="note", referencedColumnName="id",onDelete="CASCADE")}
     * )
     */
    private $notes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Event")
     * @ORM\JoinTable(name="lead_events",
     *     joinColumns={@ORM\JoinColumn(name="lead", referencedColumnName="id",onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="event", referencedColumnName="id",onDelete="CASCADE")}
     * )
     */
    private $events;

    /**
     * @return mixed
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param mixed $person
     */
    public function setPerson($person): void
    {
        $this->person = $person;
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
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
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
    public function getLeadSource()
    {
        return $this->leadSource;
    }

    /**
     * @param mixed $leadSource
     */
    public function setLeadSource($leadSource): void
    {
        $this->leadSource = $leadSource;
    }

    /**
     * @return mixed
     */
    public function getCampaign()
    {
        return $this->campaign;
    }

    /**
     * @param mixed $campaign
     */
    public function setCampaign($campaign): void
    {
        $this->campaign = $campaign;
    }

    /**
     * @return mixed
     */
    public function getAssignedTo()
    {
        return $this->assignedTo;
    }

    /**
     * @param mixed $assignedTo
     */
    public function setAssignedTo($assignedTo): void
    {
        $this->assignedTo = $assignedTo;
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
     *
     */
    public function addNote($note)
    {
        $this->notes[] = $note;
    }

    /**
     * @return mixed
     */
    public function addEvent($event)
    {
        $this->events[] = $event;
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
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getLeadId()
    {
        return $this->leadId;
    }

    /**
     * @param mixed $leadId
     */
    public function setLeadId($leadId): void
    {
        $this->leadId = $leadId;
    }



}
