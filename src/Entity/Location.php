<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 20/05/2019
 * Time: 11:21 PM
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Event
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table("locations")
 */
class Location extends BaseObject
{

    /**
     * @ORM\Column(length=255)
     */
    private $name;

//    /**
//     * @ORM\ManyToOne(targetEntity="Address")
//     * @ORM\JoinColumn(name="address", referencedColumnName="id")
//     */
//    private $address;

    /**
     * @ORM\Column(length=255)
     */
    private $geoSpatial;

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

//    /**
//     * @return mixed
//     */
//    public function getAddress()
//    {
//        return $this->address;
//    }
//
//    /**
//     * @param mixed $address
//     */
//    public function setAddress($address): void
//    {
//        $this->address = $address;
//    }

    /**
     * @return mixed
     */
    public function getGeoSpatial()
    {
        return $this->geoSpatial;
    }

    /**
     * @param mixed $geoSpatial
     */
    public function setGeoSpatial($geoSpatial): void
    {
        $this->geoSpatial = $geoSpatial;
    }


}