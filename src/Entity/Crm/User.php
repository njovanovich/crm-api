<?php
/**
 * User.php
 * Created by: nick
 * @ 11/12/2019 5:33 PM
 * Project: crm
 *
 * Copyright © 2019 Total Business Information Solutions Pty Ltd
 *
 */


namespace App\Entity\Crm;

use App\Entity\Person;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package App\Entity\Crm
 * @ORM\Entity()
 * @ORM\Table("users")
 */
class User extends Person
{

    /**
     * @ORM\Column(length=255)
     */
    private $username;

    /**
     * @ORM\Column(length=255)
     */
    private $password;

    /**
     * @ORM\Column(name="last_logged_in")
     */
    private $lastLoggedIn;

    /**
     * @ORM\Column(name="last_ip",length=30)
     */
    private $lastIp;

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

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
        $this->password = $password;
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
    public function getLastIp()
    {
        return $this->lastIp;
    }

    /**
     * @param mixed $lastIp
     */
    public function setLastIp($lastIp): void
    {
        $this->lastIp = $lastIp;
    }

}