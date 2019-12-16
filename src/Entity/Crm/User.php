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

}