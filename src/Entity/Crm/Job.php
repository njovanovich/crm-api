<?php
/**
 * Job.php
 * Created by: nick
 * @ 17/12/2019 9:06 AM
 * Project: crm
 *
 * Copyright © 2019 Total Business Information Solutions Pty Ltd
 *
 */


namespace App\Entity\Crm;

use App\Entity\BaseObject;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Job
 * @package App\Entity\Crm
 * @ORM\Entity()
 * @ORM\Table("jobs")
 */
class Job extends BaseObject
{
    /**
     * @ORM\Column(length=255)
     */
    private $jobId;

    /**
     * @ORM\Column(length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Properties")
     * @ORM\JoinTable(name="jobs_to_properties",
     *      joinColumns={@ORM\JoinColumn(name="job", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="properties", referencedColumnName="id")}
     *      )
     */
    private $jobProperties;

    /**
     * @ORM\Column(type="datetime")
     */
    private $deliveryDate;

    /**
     * @return mixed
     */
    public function getJobId()
    {
        return $this->jobId;
    }

    /**
     * @param mixed $jobId
     */
    public function setJobId($jobId): void
    {
        $this->jobId = $jobId;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getJobProperties()
    {
        return $this->jobProperties;
    }

    /**
     * @param mixed $jobProperties
     */
    public function setJobProperties($jobProperties): void
    {
        $this->jobProperties = $jobProperties;
    }

    /**
     * @return mixed
     */
    public function getDeliveryDate()
    {
        return $this->deliveryDate;
    }

    /**
     * @param mixed $deliveryDate
     */
    public function setDeliveryDate($deliveryDate): void
    {
        $this->deliveryDate = $deliveryDate;
    }



}
