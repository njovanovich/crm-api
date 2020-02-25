<?php

namespace App\Controller\Crm;

use App\Entity\Crm\Quote;
use App\Form\Crm\QuoteType;
use App\Controller\BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/quote")
 */
class QuoteController extends AbstractController
{
    /**
     * @Route("/", name="crm_quote_index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        return $base->index(Quote::class, [BaseController::SEARCH_DEEP]);
    }

    /**
     * @Route("/new", name="crm_quote_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->new($request, Quote::class, QuoteType::class);
    }

    /**
     * @Route("/{id}", name="crm_quote_show", methods={"GET"})
     */
    public function show(Quote $quote): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->show($quote, Quote::class);
    }

    /**
     * @Route("/{id}/edit", name="crm_quote_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Quote $quote): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->edit($request, $quote, QuoteType::class);
    }

    /**
     * @Route("/{id}", name="crm_quote_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Quote $quote): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->delete($request, $quote, $token='');
    }
}
