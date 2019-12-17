<?php
/**
 * Entity.php
 * Created by: nick
 * @ 11/12/2019 4:49 PM
 * Project: crm
 *
 * Copyright © 2019 Total Business Information Solutions Pty Ltd
 *
 */


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Entity
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table("entities")
 */
class Entity extends BaseObject
{

    /**
     * @ORM\Column(length=255)
     */
    protected $type;

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