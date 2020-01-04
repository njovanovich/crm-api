<?php

namespace App\Controller\Crm;

use App\Entity\Crm\TaxRate;
use App\Form\Crm\TaxRateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/crm/tax/rate")
 */
class TaxRateController extends AbstractController
{
    /**
     * @Route("/", name="crm_tax_rate_index", methods={"GET"})
     */
    public function index(): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->index(TaxRate::class);
    }

    /**
     * @Route("/new", name="crm_tax_rate_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->new($request, TaxRate::class, TaxRateType::class);
    }

    /**
     * @Route("/{id}", name="crm_tax_rate_show", methods={"GET"})
     */
    public function show(TaxRate $taxRate): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->show($taxRate, TaxRate::class);
    }

    /**
     * @Route("/{id}/edit", name="crm_tax_rate_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TaxRate $taxRate): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->edit($request, $taxRate, TaxRateType::class);
    }

    /**
     * @Route("/{id}", name="crm_tax_rate_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TaxRate $taxRate): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->delete($request, $taxRate, $token='');
    }
}
