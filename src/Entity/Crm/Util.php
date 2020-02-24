<?php
/**
 * Util.php
 * Created by: nick
 * @ 17/02/2020 2:16 am
 * Project: crm
 *
 * Copyright © 2020 Total Business Information Solutions Pty Ltd
 *
 */


namespace App\Entity\Crm;


use Symfony\Component\Config\Definition\Exception\Exception;

class Util
{

    static public function getClassName($machineName){
        $className = "";
        switch($machineName){
            case "person":
                $className = "App\Entity\Person";
                break;
            case "event":
                $className = "App\Entity\Event";
                break;
            case "call":
                $className = "App\Entity\Crm\Call";
                break;
            case "business":
                $className = "App\Entity\Crm\Business";
                break;
            case "quote":
                $className = "App\Entity\Crm\Quote";
                break;
            case "lead":
                $className = "App\Entity\Crm\Lead";
                break;
            case "job":
                $className = "App\Entity\Crm\Job";
                break;
            default:
                throw new Exception("Cannot change machine name of entity to classname");
        }
        return $className;
    }



}