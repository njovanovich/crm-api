<?php
/**
 * DataController.php
 * Created by: nick
 * @ 5/10/2019 5:11 PM
 * Project: symfony
 *
 * Copyright © 2019 Total Business Information Solutions Pty Ltd
 *
 */


// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class DataController
{
    public function test()
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: ' . $number . '</body></html>'
        );
    }
}