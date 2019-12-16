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
class Person extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Person")
     * @ORM\JoinColumn(name="created_by_id", referencedColumnName="id")
     */
    protected $createdBy;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Permission")
     * @ORM\JoinColumn(name="permission_id", referencedColumnName="id")
     */
    protected $permissions;

    /**
     * @ORM\Column(name="updated_by_id")
     * @ORM\OneToOne(targetEntity="App\Entity\Person")
     */
    protected $updatedBy;

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

    /**
     * @ORM\ManyToOne(targetEntity="Relationship")
     */
    private $relationships;

    /**
     * @ORM\ManyToOne(targetEntity="Location")
     */
    private $locations;

    /**
     * @ORM\OneToMany(targetEntity="ContactDetails", mappedBy="market", indexBy="symbol"))
     */
    private $contactDetails;

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


}