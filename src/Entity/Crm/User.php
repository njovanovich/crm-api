<?php
/**
 * User.php
 * Created by: nick
 * @ 11/12/2019 5:33 PM
 * Project: crm_business
 *
 * Copyright © 2019 Total Business Information Solutions Pty Ltd
 *
 */


namespace App\Entity\Crm;

use App\Entity\Person;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class User
 * @package App\Entity\Crm
 * @ORM\Entity()
 * @ORM\Table("users")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime")
	 * @Gedmo\Timestampable(on="update")
     */
    protected $updated;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Crm\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    protected $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Crm\User")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id")*
     */
    protected $updatedBy;

    /**
     * @ORM\Column(length=255)
     */
    private $email;

    /**
     * @ORM\Column(length=255)
     */
    private $name;

    /**
     * @ORM\Column(length=255)
     */
    private $userlevel;

    /**
     * @ORM\Column(length=255)
     */
    private $password;

    /**
     * @ORM\Column(name="reset_password",type="integer",nullable=true)
     */
    private $resetPassword;

    /**
     * @ORM\Column(name="last_logged_in",type="datetime",nullable=true)
     */
    private $lastLoggedIn;

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = Util::encryptPassword($password);
    }

    /**
     * @return mixed
     */
    public function getLastLoggedIn()
    {
        return $this->lastLoggedIn;
    }

    /**
     * @param mixed $lastLoggedIn
     */
    public function setLastLoggedIn($lastLoggedIn): void
    {
        $this->lastLoggedIn = $lastLoggedIn;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created): void
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated($updated): void
    {
        $this->updated = $updated;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $createdBy
     */
    public function setCreatedBy($createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return mixed
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @param mixed $updatedBy
     */
    public function setUpdatedBy($updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
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
    public function getUserlevel()
    {
        return $this->userlevel;
    }

    /**
     * @param mixed $userlevel
     */
    public function setUserlevel($userlevel): void
    {
        $this->userlevel = $userlevel;
    }

    /**
     * @return mixed
     */
    public function getResetPassword()
    {
        return $this->resetPassword;
    }

    /**
     * @param mixed $resetPassword
     */
    public function setResetPassword($resetPassword): void
    {
        $this->resetPassword = $resetPassword;
    }



}