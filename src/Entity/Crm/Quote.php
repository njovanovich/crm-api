<?php
/**
 * Quote.php
 * Created by: nick
 * @ 13/12/2019 11:43 PM
 * Project: crm_business
 *
 * Copyright © 2019 Total Business Information Solutions Pty Ltd
 *
 */


namespace App\Entity\Crm;

use App\Entity\BaseObject;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Quote
 * @package App\Entity\Crm
 * @ORM\Entity()
 * @ORM\Table("quotes")
 */
class Quote
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

//    /**
//     * @ORM\Column(type="datetime")
//     * @Gedmo\Timestampable(on="create")
//     */
//    protected $created;
//
//    /**
//     * @ORM\Column(type="datetime",columnDefinition="TIMESTAMP ON UPDATE CURRENT_TIMESTAMP")
//     */
//    protected $updated;
//
//    /**
//     * @ORM\ManyToOne(targetEntity="App\Entity\Crm\User")
//     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
//     */
//    protected $createdBy;
//
//    /**
//     * @ORM\ManyToOne(targetEntity="App\Entity\Crm\User")
//     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id")*
//     */
//    protected $updatedBy;
//
//    /**
//     * @ORM\Column(name="quote_number",length=40)
//     */
//    private $quoteNumber;
//
//    /**
//     * @ORM\ManyToOne(targetEntity="App\Entity\Person")
//     * @ORM\JoinColumn(name="person", referencedColumnName="id")
//     */
//    private $person;
//
//    /**
//     * @ORM\ManyToOne(targetEntity="Business")
//     * @ORM\JoinColumn(name="business", referencedColumnName="id")
//     */
//    private $business;
//
//    /**
//     * @ORM\Column(type="text")
//     */
//    private $quoteLines;
//
//    /**
//     * @ORM\ManyToMany(targetEntity="App\Entity\Crm\Note")
//     * @ORM\JoinTable(name="quote_notes",
//     *      joinColumns={@ORM\JoinColumn(name="quote", referencedColumnName="id")},
//     *      inverseJoinColumns={@ORM\JoinColumn(name="note", referencedColumnName="id", unique=true)}
//     *      )
//     */
//    private $notes;

}