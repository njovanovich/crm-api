<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 20/05/2019
 * Time: 11:20 PM
 */

namespace App\Entity;

use App\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Person
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table("people")
 */
class Person extends BaseObject
{
    /**
     * @ORM\Column(length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(length=255)
     */
    private $middleName;

    /**
     * @ORM\Column(length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(length=10)
     */
    private $gender;

    /**
     * @ORM\Column(length=255)
     */
    private $email;

//    /**
//     * @ORM\ManyToOne(targetEntity="Relationship")
//     */
//    private $relationships;

//    /**
//     * @ORM\ManyToOne(targetEntity="Location")
//     */
//    private $locations;

    /**
     * @ORM\ManyToMany(targetEntity="Permission")
     * @ORM\JoinTable(name="person_permission",
     *      joinColumns={@ORM\JoinColumn(name="person", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="permission", referencedColumnName="id")}
     *      )
     */
    protected $permissions;

    /**
     * @ORM\ManyToMany(targetEntity="ContactDetails"))
     * @ORM\JoinTable(name="person_contacts",
     *      joinColumns={@ORM\JoinColumn(name="person", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="contact", referencedColumnName="id")}
     *      )
     */
    private $contactDetails;

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
    public function getRelationships()
    {
        return $this->relationships;
    }

    /**
     * @param mixed $relationships
     */
    public function setRelationships($relationships): void
    {
        $this->relationships = $relationships;
    }

    /**
     * @return mixed
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * @param mixed $locations
     */
    public function setLocations($locations): void
    {
        $this->locations = $locations;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @param mixed $middleName
     */
    public function setMiddleName($middleName): void
    {
        $this->middleName = $middleName;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getContactDetails()
    {
        return $this->contactDetails;
    }

    /**
     * @param mixed $contactDetails
     */
    public function setContactDetails($contactDetails): void
    {
        $this->contactDetails = $contactDetails;
    }


}