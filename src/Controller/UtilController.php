<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/util")
 */
class UtilController extends AbstractController
{
    /**
     * @Route("/toolbar", name="display_toolbar", methods={"GET"})
     */
    public function toolbar(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $base->checkLogin();
        $base->checkCsrf();

        $objects = [
            [
                'name' => 'Leads',
                'image' => '/images/icons/icons8/16px/icons8-money-16.png',
                'onclick' => 'Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlLead");',
            ],
            [
                'name' => 'People',
                'image' => '/images/icons/icons8/16px/icons8-people-16.png',
                'onclick' => 'Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlPerson");',
            ],
            [
                'name' => 'Quotes',
                'image' => '/images/icons/png/16x16/DocumentExport.png',
                'onclick' => 'Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlQuote");',
            ],
            [
                'name' => 'Accounts',
                'image' => '/images/icons/png/16x16/Account.png',
                'onclick' => 'Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlBusiness");',
            ],
            [
                'name' => 'Jobs',
                'image' => '/images/icons/png/16x16/Gear.png',
                'onclick' => 'Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlJob");',
            ]
        ];
        if ($base->getUserlevel() == 'admin') {
            $objects[] =
                [
                    'name' => 'Users',
                    'image' => '/images/icons/png/16x16/User2.png',
                    'onclick' => '
                        Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlAdmin");
                        Ext.getCmp("tbpAdmin").getLayout().setActiveItem("grdUser");
                    ',
                    ];
        }
        $objects[] = [
                'name' => 'Reports',
                'image' => '/images/icons/png/16x16/Piechart.png',
                'onclick' => 'Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlReports");',
            ];
        if ($base->getUserlevel() == 'admin') {
            $objects[] = [
                'name' => 'Admin',
                'image' => '/images/icons/icons8/16px/icons8-admin-settings-male-16.png',
                'onclick' => 'Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlAdmin");',
            ];
        }

        $objects[] = [
            'name' => 'Logout',
            'image' => '/images/icons/png/16x16/Key.png',
            'onclick' => '
                    Ext.Ajax.request({
                        url: "/api/user/logout",
                        method: "GET",
                        success: function(){
                            location.reload();
                        }
                    });
            ',
        ];

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
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $base->checkLogin();
        $base->checkCsrf();

        $objects = [
            [
                'id' => 'pnlLead',
            ],
            [
                'id' => 'pnlPerson',
            ],
            [
                'id' => 'pnlQuote',
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
        ];
        if ($base->getUserlevel() == 'admin') {
            $objects[] = [
                'id' => 'pnlAdmin',
            ];
        }

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

        /*$base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $base->checkLogin();
        $base->checkCsrf();*/

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
                            'text' => 'Make Calls',
                            'onclick' => '
                                var w=fetchOrCreate("wndMakeCall");
                                w.show();
                            ',
                            'icon' => '/images/icons/png/16x16/Mobile.png',
                            'cls' => 'pointer',
                            'leaf' => true,
                        ],
                        (object)[
                            'text' => 'Create Lead',
                            'onclick' => '
                                var w=fetchOrCreate("wndLead");
                                w.show();
                            ',
                            'icon' => '/images/icons/png/16x16/Sync.png',
                            'cls' => 'pointer',
                            'leaf' => true,
                        ],
                        (object)[
                            'text' => 'All Leads',
                            'onclick' => '
                                Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlLead");
                                Ext.getCmp("tbpLead").getLayout().setActiveItem("grdLead");
                                Ext.getCmp("grdLead").getStore().clearFilter();
                                Ext.getCmp("grdLead").getStore().load();
                            ',
                            'icon' => '/images/icons/icons8/16px/icons8-money-16.png',
                            'cls' => 'pointer',
                            'leaf' => true,
                        ],
                        (object)[
                            'text' => 'New Leads',
                            'onclick' => '
                                Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlLead");
                                Ext.getCmp("tbpLead").getLayout().setActiveItem("grdLead");
                                Ext.getCmp("grdLead").getStore().filter("status","new");
                                Ext.getCmp("grdLead").getStore().reload();
                            ',
                            'icon' => '/images/icons/icons8/16px/icons8-money-16.png',
                            'cls' => 'pointer',
                            'leaf' => true,
                        ],
                        (object)[
                            'text' => 'Quoting Leads',
                            'onclick' => '
                                Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlLead");
                                Ext.getCmp("tbpLead").getLayout().setActiveItem("grdLead");
                                Ext.getCmp("grdLead").getStore().filter("status","quoting");
                                Ext.getCmp("grdLead").getStore().reload();
                            ',
                            'icon' => '/images/icons/icons8/16px/icons8-money-16.png',
                            'cls' => 'pointer',
                            'leaf' => true,
                        ],
                        (object)[
                            'text' => 'Won Leads',
                            'onclick' => '
                                Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlLead");
                                Ext.getCmp("tbpLead").getLayout().setActiveItem("grdLead");
                                Ext.getCmp("grdLead").getStore().filter("status","closed - won");
                                Ext.getCmp("grdLead").getStore().reload();
                            ',
                            'icon' => '/images/icons/icons8/16px/icons8-money-16.png',
                            'cls' => 'pointer',
                            'leaf' => true,
                        ],
                        (object)[
                            'text' => 'Lost Leads',
                            'onclick' => '
                                Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlLead");
                                Ext.getCmp("tbpLead").getLayout().setActiveItem("grdLead");
                                Ext.getCmp("grdLead").getStore().filter("status","closed - lost");
                                Ext.getCmp("grdLead").getStore().reload();
                            ',
                            'icon' => '/images/icons/icons8/16px/icons8-money-16.png',
                            'cls' => 'pointer',
                            'leaf' => true,
                        ],
                        (object)[
                            'text' => 'Import Leads',
                            'onclick' => '
                                var window = fetchOrCreate("wndImport");
                                window.show();
                            ',
                            'icon' => '/images/icons/png/16x16/Database.png',
                            'cls' => 'pointer',
                            'leaf' => true,
                        ]
                    ]
                ],
                (object)[
                    'text' => 'People',
                    'onclick' => '',
                    'leaf' => false,
                    'children' => [
                        (object)[
                            'text' => 'People',
                            'icon' => '/images/icons/icons8/16px/icons8-people-16.png',
                            'onclick' => 'Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlPerson");',
                            'cls' => 'pointer',
                            'leaf' => true,
                        ]
                    ]
                ],
                (object)[
                    'text' => 'Quotes',
                    'onclick' => '',
                    'leaf' => false,
                    'children' => [
                        (object)[
                            'text' => 'Quotes',
                            'onclick' => 'Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlQuote");',
                            'icon' => '/images/icons/png/16x16/DocumentExport.png',
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
                            'text' => 'Accounts',
                            'icon' => '/images/icons/png/16x16/Account.png',
                            'onclick' => 'Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlBusiness");',
                            'cls' => 'pointer',
                            'leaf' => true,
                        ]
                    ]
                ],
                (object)[
                    'text' => 'Jobs',
                    'onclick' => '',
                    'leaf' => false,
                    'children' => [
                        (object)[
                            'text' => 'Jobs',
                            'icon' => '/images/icons/png/16x16/Gear.png',
                            'onclick' => 'Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlJob");',
                            'cls' => 'pointer',
                            'leaf' => true,
                        ]
                    ]
                ],
                (object)[
                    'text' => 'Reports',
                    'onclick' => '',
                    'leaf' => false,
                    'children' => [
                        (object)[
                            'text' => 'Reports',
                            'icon' => '/images/icons/png/16x16/Piechart.png',
                            'onclick' => 'Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlReports");',
                            'cls' => 'pointer',
                            'leaf' => true,
                        ]
                    ]
                ],
           ]
        ];

        $content = json_encode($objects);
        $response = new Response($content);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/icons", name="display_icons", methods={"GET"})
     */
    public function icons(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $base->checkLogin();
        $base->checkCsrf();

        $objects = [
            [
                'name' => 'Make Calls',
                'image' => '/images/icons/png/128x128/Mobile.png',
                'onclick'=> 'var w=fetchOrCreate("wndMakeCall");w.show();',
            ],
            [
                'name' => 'Leads',
                'image' => '/images/icons/icons8/64px/icons8-money-64.png',
                'onclick'=> 'Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlLead");',
            ],
            [
                'name' =>'Accounts',
                'image'=>'/images/icons/png/128x128/Account.png',
                'onclick'=>'Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlBusiness");',
            ],
            [
                'name'=>'Quotes',
                'image'=>'/images/icons/png/128x128/DocumentExport.png',
                'onclick'=>'Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlQuote");',
            ],
            [
                'name'=>'Jobs',
                'image'=>'/images/icons/png/128x128/Gear.png',
                'onclick'=>'Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlJob");',
            ],
            [
                'name'=>'People',
                'image'=>'/images/icons/icons8/64px/icons8-people-64.png',
                'onclick'=>'Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlPerson");',
            ]
        ];
        if ($base->getUserlevel() == 'admin') {
            $objects[] =
                [
                    'name' => 'Users',
                    'image' => '/images/icons/png/128x128/User2.png',
                    'onclick' => 'Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlAdmin");
                    Ext.getCmp("tbpAdmin").getLayout().setActiveItem("grdUser");',
                ];
        }
        $objects[] =[
                'name'=>'Reports',
                'image'=>'/images/icons/png/128x128/Piechart.png',
                'onclick'=>'Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlReports");',
            ];

        if ($base->getUserlevel() == 'admin') {
            $objects[] = [
                'name' => 'Admin',
                'image' => '/images/icons/icons8/64px/icons8-admin-settings-male-64.png',
                'onclick' => 'Ext.getCmp("tbpMain").getLayout().setActiveItem("pnlAdmin");',
            ];
        }

        $objects[] = [
                'name'=>'Logout',
                'image'=>'/images/icons/png/128x128/Key.png',
                'onclick'=>'
                    Ext.Ajax.request({
                        url: "/api/user/logout",
                        method: "GET",
                        success: function(){
                            location.reload();
                        }
                    });
                ',
            ];

        $response = new JsonResponse();
        $response->setData($objects);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/csrf", name="get_csrf", methods={"GET"})
     */
    public function getCsrf(): Response
    {

        $session = new Session();

        $csrf = $session->get('csrf');
        if (!$csrf) {
            $csrf = bin2hex(random_bytes(32));
            $session->set('csrf', $csrf);
        }

        $response = new JsonResponse();
        $object = [
            "csrf" => $csrf,
            "success" => true,
        ];
        $response->setData($object);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/ping", name="ping", methods={"GET"})
     */
    public function ping(Request $request): Response
    {

        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);

        $javascript = "";
        try {
            $base->checkLogin();
            $base->checkCsrf();
        }catch(\Exception $ex){
            $javascript = "location.reload();";
        }

        $data = [
            "success" => TRUE,
            "javascript" => $javascript,
        ];

        return new JsonResponse($data);

    }
}

