<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 20/05/2019
 * Time: 11:21 PM
 */

namespace App\Entity\Crm;

use App\Entity\Event;
use App\Entity\Properties;

use Doctrine\ORM\Mapping as ORM;


/**
 * Class Service
 * @package App\Entity\Crm
 * @ORM\Entity()
 * @ORM\Table("services")
 */
class Service extends Event
{

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Properties")
     * @ORM\JoinTable(name="services_to_properties",
     *      joinColumns={@ORM\JoinColumn(name="services", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="properties", referencedColumnName="id")}
     *      )
     */
    private $serviceProperties;

    /**
     * @return mixed
     */
    public function getServiceProperties()
    {
        return $this->serviceProperties;
    }

    /**
     * @param mixed $serviceProperties
     */
    public function setServiceProperties($serviceProperties): void
    {
        $this->serviceProperties = $serviceProperties;
    }

}