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
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     */
    private $person;

    /**
     * @ORM\OneToOne(targetEntity="Business")
     * @ORM\JoinColumn(name="business_id", referencedColumnName="id")
     */
    private $business;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

}
