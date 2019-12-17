<?php
/**
 * Address.php
 * Created by: nick
 * @ 14/12/2019 10:34 PM
 * Project: crm
 *
 * Copyright © 2019 Total Business Information Solutions Pty Ltd
 *
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Event
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table("addresses")
 */
class Address extends BaseObject
{

    /**
     *  @ORM\Column(length=255)
     */
    private $name;

    /**
     *  @ORM\Column(length=255)
     */
    private $address1;

    /**
     *  @ORM\Column(length=255)
     */
    private $address2;

    /**
     *  @ORM\Column(length=255)
     */
    private $suburb;

    /**
     *  @ORM\Column(length=255)
     */
    private $state;

    /**
     *  @ORM\Column(length=12)
     */
    private $postcode;

    /**
     *  @ORM\Column(length=255)
     */
    private $country;

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
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param mixed $address1
     */
    public function setAddress1($address1): void
    {
        $this->address1 = $address1;
    }

    /**
     * @return mixed
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param mixed $address2
     */
    public function setAddress2($address2): void
    {
        $this->address2 = $address2;
    }

    /**
     * @return mixed
     */
    public function getSuburb()
    {
        return $this->suburb;
    }

    /**
     * @param mixed $suburb
     */
    public function setSuburb($suburb): void
    {
        $this->suburb = $suburb;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state): void
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param mixed $postcode
     */
    public function setPostcode($postcode): void
    {
        $this->postcode = $postcode;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

}