<?php
/**
 * Business.phpp
 * Created by: nick
 * @ 11/12/2019 7:14 PM
 * Project: crm
 *
 * Copyright © 2019 Total Business Information Solutions Pty Ltd
 *
 */

namespace App\Entity\Crm;

use App\Entity\Group;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Business
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table("businesses")
 */
class Business extends Group
{
    /**
     * @ORM\Column(name="business_number",length=255)
     */
    private $businessNumber = "business";

}