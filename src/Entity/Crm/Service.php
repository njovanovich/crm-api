<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 20/05/2019
 * Time: 11:21 PM
 */

namespace App\Entity\Crm;

use App\Entity\Event;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Service
 * @package App\Entity\Crm
 * @ORM\Entity()
 * @ORM\Table("services")
 */
class Service extends Event
{

}