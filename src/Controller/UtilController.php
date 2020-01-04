<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/util")
 */
class UtilController extends AbstractController
{
    /**
     * @Route("/toolbar", name="display_toolbar", methods={"GET"})
     */
    public function toolbar(): Response
    {
        $objects = [
            [
                'name' => 'Leads',
                'image' => 'http://local.crm/images/icons/icons8/16px/icons8-money-16.png',
                'onclick' => 'Ext.getCmp("pnlMain").getLayout().setActiveItem(1);',
            ],
            [
                'name' => 'Accounts',
                'image' => 'http://local.crm/images/icons/png/16x16/Account.png',
                'onclick' => '',
            ],
            [
                'name' => 'Jobs',
                'image' => 'http://local.crm/images/icons/png/16x16/Gear.png',
                'onclick' => '',
            ],
            [
                'name' => 'People',
                'image' => 'http://local.crm/images/icons/icons8/16px/icons8-people-16.png',
                'onclick' => '',
            ],
            [
                'name' => 'Tasks',
                'image' => 'http://local.crm/images/icons/png/16x16/TaskBoard.png',
                'onclick' => '',
            ],
            [
                'name' => 'Users',
                'image' => 'http://local.crm/images/icons/png/16x16/User2.png',
                'onclick' => '',
            ],
            [
                'name' => 'Reports',
                'image' => 'http://local.crm/images/icons/png/16x16/Piechart.png',
                'onclick' => '',
            ],
            [
                'name' => 'Admin',
                'image' => 'http://local.crm/images/icons/icons8/16px/icons8-admin-settings-male-16.png',
                'onclick' => 'alert("last");',
            ]];

        $response = new JsonResponse();
        $response->setData($objects);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/tabs", name="get_tabs", methods={"GET"})
     */
    public function tabs(Request $request): Response
    {
        $objects = [
            [
                'id' => 'pnlLeads',
            ],
            [
                'id' => 'pnlAccounts',
            ],
            [
                'id' => 'pnlJobs',
            ],
            [
                'id' => 'pnlReports',
            ],
            [
                'id' => 'pnlAdmin',
            ],
        ];

        $response = new JsonResponse();
        $response->setData($objects);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/treemenu", name="display_treemenu", methods={"GET"})
     */
    public function treemenu(Request $request): Response
    {

        $objects = (object)[
            "success" => true,
            'leaf' => false,
            'text' => 'Root',
            'children' => [
                (object)[
                    'text' => 'Leads',
                    'onclick' => '',
                    'leaf' => false,
                    'expanded' => true,
                    'children' => [
                        (object)[
                            'text' => 'All Leads',
                            'onclick' => 'Ext.getCmp("pnlMain").getLayout().setActiveItem(1);',

                            'icon' => 'http://local.crm/images/icons/icons8/16px/icons8-money-16.png',
                            'cls' => 'pointer',
                            'leaf' => true,
                        ]
                    ]
                ],
                (object)[
                    'text' => 'Accounts',
                    'onclick' => '',
                    'leaf' => false,
                    'children' => [
                        (object)[
                            'text' => 'Accounts2',
                            'onclick' => '',
                            'cls' => 'pointer',
                            'leaf' => true,
                        ]
                    ]
                ],
           ]
        ];

        //$content = $request->get('callback') . "(".json_encode($objects, true).");";
        $content = json_encode($objects);
        $response = new Response($content);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/icons", name="display_icons", methods={"GET"})
     */
    public function icons(): Response
    {
        $objects = [
            [
                'name' => 'Leads',
                'image' => 'http://local.crm/images/icons/icons8/64px/icons8-money-64.png',
                'onclick'=> 'Ext.getCmp("pnlMain").getLayout().setActiveItem(1);',
            ],
            [
                'name' =>'Accounts',
                'image'=>'http://local.crm/images/icons/png/128x128/Account.png',
                'onclick'=>'alert("hi");',
            ],
            [
                'name'=>'Jobs',
                'image'=>'http://local.crm/images/icons/png/128x128/Gear.png',
                'onclick'=>'alert("hi");',
            ],[
                'name'=>'Services',
                'image'=>'http://local.crm/images/icons/png/128x128/Execute.png',
                'onclick'=>'alert("hi");',
            ],
            [
                'name'=>'People',
                'image'=>'http://local.crm/images/icons/icons8/64px/icons8-people-64.png',
                'onclick'=>'alert("hi");',
            ],
            [
                'name'=>'Users',
                'image'=>'http://local.crm/images/icons/png/128x128/User2.png',
                'onclick'=>'alert("hi");',
            ],[
                'name'=>'Reports',
                'image'=>'http://local.crm/images/icons/png/128x128/Piechart.png',
                'onclick'=>'alert("hi");',
            ],
            [
                'name'=>'Admin',
                'image'=>'http://local.crm/images/icons/icons8/64px/icons8-admin-settings-male-64.png',
                'onclick'=>'alert("hi");',
             ]];

        $response = new JsonResponse();
        $response->setData($objects);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/login", name="login_user", methods={"GET"})
     */
    public function login(): Response
    {

        $response = new JsonResponse();
        //$response->setData($objects);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
