<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 24/05/2019
 * Time: 7:32 PM
 */

namespace App\Entity\Crm;

use App\Entity\BaseObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Lead
 * @package App\Entity\Crm
 * @ORM\Entity()
 * @ORM\Table("leads")
 */
class Lead extends BaseObject
{

    /**
     * @ORM\Column(length=255)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Person")
     * @ORM\JoinColumn(name="person", referencedColumnName="id")
     */
    private $person;

    /**
     * @ORM\OneToOne(targetEntity="Business")
     * @ORM\JoinColumn(name="business", referencedColumnName="id")
     */
    private $business;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

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



}
