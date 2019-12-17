<?php
/**
 * Invoice.php
 * Created by: nick
 * @ 17/12/2019 12:27 PM
 * Project: crm
 *
 * Copyright © 2019 Total Business Information Solutions Pty Ltd
 *
 */


namespace App\Entity\Crm;

use App\Entity\BaseObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Invoice
 * @package App\Entity\Crm
 * @ORM\Entity()
 * @ORM\Table("invoices")
 */
class Invoice extends BaseObject
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person")
     * @ORM\JoinColumn(name="person", referencedColumnName="id")
     */
    private $contact;

    /**
     * @ORM\ManyToOne(targetEntity="Business")
     * @ORM\JoinColumn(name="business", referencedColumnName="id")
     */
    private $business;

    /**
     * @ORM\Column(type="text")
     */
    private $invoiceLines;

}