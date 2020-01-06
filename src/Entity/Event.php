<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 20/05/2019
 * Time: 11:24 PM
 */

namespace App\Entity;

use App\Entity\Location;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Event
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table("events")
 */
class Event
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateTime;

    /**
     * @ORM\Column()
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="Location")
     * @ORM\JoinColumn(name="location", referencedColumnName="id")
     */
    //private $location;

    /**
     * @ORM\ManyToMany(targetEntity="Person")
     * @ORM\JoinTable(name="person_events",
     *      joinColumns={@ORM\JoinColumn(name="person", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="event", referencedColumnName="id")}
     *      )
     */
    private $people;

    /**
     * Duration in minutes
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column()
     */
    private $type;

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
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
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @param mixed $dateTime
     */
    public function setDateTime($dateTime): void
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @return mixed
     */
    public function getPeople()
    {
        return $this->people;
    }

    /**
     * @param mixed $people
     */
    public function setPeople($people): void
    {
        $this->people = $people;
    }

    /**
     * @param mixed $people
     */
    public function addPerson($people): void
    {
        $this->people[] = $people;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }


}