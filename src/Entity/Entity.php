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
class Entity
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
    private $type;

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