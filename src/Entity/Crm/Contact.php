<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 22/05/2019
 * Time: 5:16 PM
 */

namespace App\Entity\Crm;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Person as Person;

/**
 * Class Contact
 * @package App\Entity\Crm
 * @ORM\Entity()
 * @ORM\Table("contacts")
 */
class Contact extends Person
{
    /**
     * @ORM\Column(name="contact_type",length=255)
     */
    private $contactType;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Person")
     * @ORM\JoinTable(name="users_groups",
     *      joinColumns={@ORM\JoinColumn(name="user", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group", referencedColumnName="id")}
     *      )
     */
    var $person;
}