<?php

namespace App\Controller\Crm;

use App\Entity\Crm\Invoice;
use App\Form\Crm\InvoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/invoice")
 */
class InvoiceController extends AbstractController
{
    /**
     * @Route("/", name="crm_invoice_index", methods={"GET"})
     */
    public function index(): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->index(Invoice::class);
    }

    /**
     * @Route("/new", name="crm_invoice_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->new($request, "App\Entity\Crm\Invoice", "App\Form\Crm\InvoiceType");
    }

    /**
     * @Route("/{id}", name="crm_invoice_show", methods={"GET"})
     */
    public function show(Invoice $invoice): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->show($invoice, Invoice::class);
    }

    /**
     * @Route("/{id}/edit", name="crm_invoice_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Invoice $invoice): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->edit($request, $invoice, InvoiceType::class);
    }

    /**
     * @Route("/{id}", name="crm_invoice_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Invoice $invoice): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->delete($request, $invoice, $token='');
    }
}
