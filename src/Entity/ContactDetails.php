<?php
/**
 * ContactDetails.php
 * Created by: nick
 * @ 17/12/2019 1:47 AM
 * Project: crm
 *
 * Copyright © 2019 Total Business Information Solutions Pty Ltd
 *
 */


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ContactDetails
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table("contact_details")
 */
class ContactDetails extends BaseObject
{

    /**
     * @ORM\Column(length=20)
     */
    private $type;

    /**
     * @ORM\Column(length=50)
     */
    private $details;


}