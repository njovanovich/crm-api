<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 22/05/2019
 * Time: 5:16 PM
 */

namespace App\Entity\Crm;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Contact
 * @package App\Entity\Crm
 * @ORM\Entity()
 * @ORM\Table("contacts")
 */
class Contact extends \App\Entity\Person
{
    /**
     * @ORM\Column(name="contact_type",length=255)
     */
    private $contactType;

    /**
     * @ORM\OneToOne(targetEntity="Note")
     * @ORM\JoinColumn(name="note_id", referencedColumnName="id")
     */
    private $note;

}