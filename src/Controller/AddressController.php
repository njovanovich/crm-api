<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/address")
 */
class AddressController extends AbstractController
{
    /**
     * @Route("/", name="address_index", methods={"GET"})
     */
    public function index(): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->index(Address::class);
    }

    /**
     * @Route("/new", name="address_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->new($request, "App\Entity\Address", "App\Form\AddressType");
    }

    /**
     * @Route("/{id}", name="address_show", methods={"GET"})
     */
    public function show(Address $address): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->show($address, Address::class);
    }

    /**
     * @Route("/{id}/edit", name="address_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Address $address): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->edit($request, $address, AddressType::class);
    }

    /**
     * @Route("/{id}", name="address_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Address $address): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->delete($request, $address, $token='');
    }
}
