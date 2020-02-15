<?php

namespace App\Controller\Crm;

use App\Entity\Crm\Service;
use App\Form\Crm\ServiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/service")
 */
class ServiceController extends AbstractController
{
    /**
     * @Route("/", name="crm_service_index", methods={"GET"})
     */
    public function index(): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->index(Service::class);
    }

    /**
     * @Route("/new", name="crm_service_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->new($request, Service::class, ServiceType::class);
    }

    /**
     * @Route("/{id}", name="crm_service_show", methods={"GET"})
     */
    public function show(Service $service): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->show($service, Service::class);
    }

    /**
     * @Route("/{id}/edit", name="crm_service_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Service $service): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->edit($request, $service, ServiceType::class);
    }

    /**
     * @Route("/{id}", name="crm_service_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Service $service): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->delete($request, $service, $token='');
    }
}
