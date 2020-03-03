<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Crm\Business;
use App\Form\AddressType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

/**
 * @Route("/address")
 */
class AddressController extends AbstractController
{

    /**
     * @Route("/new", name="address_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $base->checkLogin();
        $base->checkCsrf();

        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // set the address to tbe business
            $businessId = $request->get('businessId');
            $repo = $entityManager->getRepository(Business::class);
            $business = $repo->find($businessId);
            $business->setAddress($address);

            // persist & flush
            $entityManager->persist($business);
            $entityManager->persist($address);
            $entityManager->flush();

            return new JsonResponse(["success"=>true]);
        }
        return new JsonResponse(["success"=>false], 400);
    }

    /**
     * @Route("/{id}/edit", name="address_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Address $address): Response
    {

        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $base->checkLogin();
        $base->checkCsrf();

        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(["success"=>TRUE]);
        }

        return new JsonResponse(["success"=>FALSE], 400);
    }

    /**
     * @Route("/{id}", name="address_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Address $address): Response
    {

        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $base->checkLogin();
        $base->checkCsrf();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($address);
        $entityManager->flush();

        return $this->redirectToRoute('address_index');
    }
}
