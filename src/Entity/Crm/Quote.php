<?php
/**
 * Quote.php
 * Created by: nick
 * @ 13/12/2019 11:43 PM
 * Project: crm
 *
 * Copyright © 2019 Total Business Information Solutions Pty Ltd
 *
 */


namespace App\Entity\Crm;

use App\Entity\BaseObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Quote
 * @package App\Entity\Crm
 * @ORM\Entity()
 * @ORM\Table("quotes")
 */
class Quote extends BaseObject
{

    /**
     * @ORM\Column(name="quote_number",length=40)
     */
    private $quoteNumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person")
     * @ORM\JoinColumn(name="contact", referencedColumnName="id")
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
    private $quoteLines;

}