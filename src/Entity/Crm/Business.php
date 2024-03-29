<?php
/**
 * Business.phpp
 * Created by: nick
 * @ 11/12/2019 7:14 PM
 * Project: crm_business
 *
 * Copyright © 2019 Total Business Information Solutions Pty Ltd
 *
 */

namespace App\Entity\Crm;

use App\Entity\Group;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Business
 * @package App\Entity\Crm
 * @ORM\Entity()
 * @ORM\Table("businesses")
 */
class Business
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Address")
     * @ORM\JoinColumn(name="address", referencedColumnName="id",onDelete="CASCADE")
     */
    protected $address;

    /**
     * @ORM\Column(nullable=true)
     */
    private $abn;

    /**
     * @ORM\Column(nullable=true)
     */
    private $acn;

    /**
     * @ORM\Column(name="misc_codes", nullable=true)
     */
    private $miscCodes;

    /**
     * @ORM\Column(type="integer",name="number_of_employees",nullable=true)
     */
    private $numberOfEmployees;

    /**
     * @ORM\Column(nullable=true)
     */
    private $industry;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $annualRevenue;

    /**
     * @ORM\Column(nullable=true)
     */
    private $type;

    /**
     * @ORM\Column()
     */
    private $name;

    /**
     * @ORM\Column(nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(nullable=true)
     */
    private $fax;

    /**
     * @ORM\Column(nullable=true)
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Crm\Note")
     * @ORM\JoinTable(name="business_notes",
     *     joinColumns={@ORM\JoinColumn(name="business_id", referencedColumnName="id",onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="note_id", referencedColumnName="id",onDelete="CASCADE")}
     * )
     */
    private $notes;

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
    public function getAbn()
    {
        return $this->abn;
    }

    /**
     * @param mixed $abn
     */
    public function setAbn($abn): void
    {
        $this->abn = $abn;
    }

    /**
     * @return mixed
     */
    public function getAcn()
    {
        return $this->acn;
    }

    /**
     * @param mixed $acn
     */
    public function setAcn($acn): void
    {
        $this->acn = $acn;
    }

    /**
     * @return mixed
     */
    public function getMiscCodes()
    {
        return $this->miscCodes;
    }

    /**
     * @param mixed $miscCodes
     */
    public function setMiscCodes($miscCodes): void
    {
        $this->miscCodes = $miscCodes;
    }

    /**
     * @return mixed
     */
    public function getNumberOfEmployees()
    {
        return $this->numberOfEmployees;
    }

    /**
     * @param mixed $numberOfEmployees
     */
    public function setNumberOfEmployees($numberOfEmployees): void
    {
        $this->numberOfEmployees = $numberOfEmployees;
    }

    /**
     * @return mixed
     */
    public function getIndustry()
    {
        return $this->industry;
    }

    /**
     * @param mixed $industry
     */
    public function setIndustry($industry): void
    {
        $this->industry = $industry;
    }

    /**
     * @return mixed
     */
    public function getAnnualRevenue()
    {
        return $this->annualRevenue;
    }

    /**
     * @param mixed $annualRevenue
     */
    public function setAnnualRevenue($annualRevenue): void
    {
        $this->annualRevenue = $annualRevenue;
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
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param mixed $website
     */
    public function setWebsite($website): void
    {
        $this->website = $website;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param mixed $fax
     */
    public function setFax($fax): void
    {
        $this->fax = $fax;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
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

    public function addNote($note)
    {
        $this->notes[] = $note;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }


}