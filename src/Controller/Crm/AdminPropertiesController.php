<?php

namespace App\Controller\Crm;

use App\Entity\Crm\AdminProperties;
use App\Form\Crm\AdminPropertiesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/crm/admin/properties")
 */
class AdminPropertiesController extends AbstractController
{
    /**
     * @Route("/", name="crm_admin_properties_index", methods={"GET"})
     */
    public function index(): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->index(AdminProperties::class);
    }

    /**
     * @Route("/new", name="crm_admin_properties_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->new($request, "App\Entity\Crm\AdminProperties", "App\Form\Crm\AdminPropertiesType");
    }

    /**
     * @Route("/{id}", name="crm_admin_properties_show", methods={"GET"})
     */
    public function show(AdminProperties $adminProperty): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->show($adminProperty, AdminProperties::class);
    }

    /**
     * @Route("/{id}/edit", name="crm_admin_properties_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AdminProperties $adminProperty): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->edit($request, $adminProperty, AdminPropertiesType::class);
    }

    /**
     * @Route("/{id}", name="crm_admin_properties_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AdminProperties $adminProperty): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->delete($request, $adminProperty, $token='');
    }
}
