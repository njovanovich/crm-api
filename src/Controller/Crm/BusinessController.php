<?php

namespace App\Controller\Crm;

use App\Entity\Crm\Business;
use App\Form\Crm\BusinessType;
use App\Controller\BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/crm/business")
 */
class BusinessController extends AbstractController
{
    /**
     * @Route("/", name="crm_business_index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;

        $limit = (int)($request->get('limit') ?? 12);
        $start = (int)($request->get('start') ?? 0);

        return $base->index(Business::class, $start, $limit);
    }

    /**
     * @Route("/new", name="crm_business_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->new($request, "App\Entity\Crm\Business", "App\Form\Crm\BusinessType");
    }

    /**
     * @Route("/{id}", name="crm_business_show", methods={"GET"})
     */
    public function show(Business $business): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->show($business, Business::class);
    }

    /**
     * @Route("/{id}/edit", name="crm_business_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Business $business): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->edit($request, $business, BusinessType::class);
    }

    /**
     * @Route("/{id}", name="crm_business_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Business $business): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->delete($request, $business, $token='');
    }
}
