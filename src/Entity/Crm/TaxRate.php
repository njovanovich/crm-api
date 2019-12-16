<?php
/**
 * TaxRate.php
 * Created by: nick
 * @ 15/12/2019 2:07 AM
 * Project: crm
 *
 * Copyright © 2019 Total Business Information Solutions Pty Ltd
 *
 */

namespace App\Entity\Crm;

use App\Entity\BaseObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TaxRate
 * @package App\Entity\Crm
 * @ORM\Entity()
 * @ORM\Table("taxrates")
 */
class TaxRate extends BaseObject
{
    /**
     * @ORM\Column(length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $rate;

}