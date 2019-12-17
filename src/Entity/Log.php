<?php
/**
 * Log.php
 * Created by: nick
 * @ 11/12/2019 10:00 PM
 * Project: crm
 *
 * Copyright © 2019 Total Business Information Solutions Pty Ltd
 *
 */


namespace App\Entity;


class Log
{

    /**
     * @ORM\Column(name="object",type="integer")
     */
    private $objectId;

    /**
     * @ORM\Column(name="object_type",length="255")
     */
    private $objectType;

    /**
     * @ORM\Column(type="text")
     */
    private $delta;

}