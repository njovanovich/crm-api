<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 20/05/2019
 * Time: 11:51 PM
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Relationship
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table("relationships")
 */
class Relationship extends BaseObject
{

    /**
     * @ORM\Column(length=255)
     */
    private $name;

    /**
     * @ORM\Column(length=255)
     */
    private $type;

    /**
     * @ORM\Column(length=255)
     */
    private $aliases;

    /**
     * @ORM\OneToOne(targetEntity="Entity")
     * @ORM\JoinColumn(name="entity", referencedColumnName="id")
     */
    private $lhsEntity;

    /**
     * @ORM\OneToOne(targetEntity="Entity")
     * @ORM\JoinColumn(name="entity2", referencedColumnName="id")
     */
    private $rhsEntity;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startTime;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endTime;

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
    public function getAliases()
    {
        return $this->aliases;
    }

    /**
     * @param mixed $aliases
     */
    public function setAliases($aliases): void
    {
        $this->aliases = $aliases;
    }

    /**
     * @return mixed
     */
    public function getLhsEntity()
    {
        return $this->lhsEntity;
    }

    /**
     * @param mixed $lhsEntity
     */
    public function setLhsEntity($lhsEntity): void
    {
        $this->lhsEntity = $lhsEntity;
    }

    /**
     * @return mixed
     */
    public function getRhsEntity()
    {
        return $this->rhsEntity;
    }

    /**
     * @param mixed $rhsEntity
     */
    public function setRhsEntity($rhsEntity): void
    {
        $this->rhsEntity = $rhsEntity;
    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param mixed $startTime
     */
    public function setStartTime($startTime): void
    {
        $this->startTime = $startTime;
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param mixed $endTime
     */
    public function setEndTime($endTime): void
    {
        $this->endTime = $endTime;
    }

}