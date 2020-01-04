<?php
/**
 * ImportController.php
 * Created by: nick
 * @ 30/12/2019 9:17 am
 * Project: crm
 *
 * Copyright © 2019 Total Business Information Solutions Pty Ltd
 *
 */


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/import")
 */
class ImportController extends AbstractController
{
    /**
     * @Route("/tables", name="get_import_tables", methods={"GET"})
     */
    public function tables(): Response
    {
        $objects = [
            [
                'table' => 'leads',
                'fields' => [
                    // lead
                    'name','amount','status','lead_source','campaign',
                    // person
                    'first_name','last_name','middle_name','gender','email',
                    // business
                    'abn','name','website','phone','fax','email','acn','misc_codes','number_of_employees','industry','annual_revenue','type',
                ],
            ],
            [
                'table' => 'accounts',
                'fields' => ['name',]
            ],
            [
                'table' => 'jobs',
                'fields' => ['name',]
            ],
            [
                'table' => 'services',
                'fields' => ['name',]
            ],
            [
                'table' => 'people',
                'fields' => ['name',]
            ]];

        return new JsonResponse(['data'=>$objects, 'success'=>true]);
    }

    /**
     * @Route("/import", name="import_table", methods={"GET"})
     */
    public function import(): Response
    {

    }
}
