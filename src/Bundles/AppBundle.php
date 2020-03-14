<?php
/**
 * AppBundle.php
 * Created by: nick
 * @ 28/02/2020 11:46 am
 * Project: crm
 *
 * Copyright © 2020 Total Business Information Solutions Pty Ltd
 *
 */


namespace App\Bundles;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Yaml\Yaml;

class AppBundle extends Bundle
{
    public function boot()
    {
        parent::boot();
        $yamlArray = Yaml::parseFile(__DIR__ . '/../../config/leadcrm.yaml');
        $timezone = 'Australia/Sydney';
        if (is_array($yamlArray)) {
            if (in_array("timezone", array_keys($yamlArray))){
                $timezone = $yamlArray["timezone"];
            }
        }
        date_default_timezone_set($timezone);
    }
}