<?php
/**
 * Properties.php
 * Created by: nick
 * @ 17/12/2019 10:05 AM
 * Project: crm
 *
 * Copyright © 2019 Total Business Information Solutions Pty Ltd
 *
 */


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Properties
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table("properties")
 */
class Properties extends BaseObject
{

    /**
     * @ORM\Column(length=255)
     */
    private $name;

    /**
     * @ORM\Column(length=255)
     */
    private $value;

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
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

}