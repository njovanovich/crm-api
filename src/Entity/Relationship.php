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
class Relationship
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
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="id")
     */
    private $lhsEntity;

    /**
     * @ORM\OneToOne(targetEntity="Entity")
     * @ORM\JoinColumn(name="entity2_id", referencedColumnName="id")
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

}