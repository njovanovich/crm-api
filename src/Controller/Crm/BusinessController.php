<?php

namespace App\Controller\Crm;

use App\Entity\Crm\Business;
use App\Form\Crm\BusinessType;
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
    public function index(): Response
    {
        $businesses = $this->getDoctrine()
            ->getRepository(Business::class)
            ->findAll();

        return $this->render('crm/business/index.html.twig', [
            'businesses' => $businesses,
        ]);
    }

    /**
     * @Route("/new", name="crm_business_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $business = new Business();
        $form = $this->createForm(BusinessType::class, $business);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($business);
            $entityManager->flush();

            return $this->redirectToRoute('crm_business_index');
        }

        return $this->render('crm/business/new.html.twig', [
            'business' => $business,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="crm_business_show", methods={"GET"})
     */
    public function show(Business $business): Response
    {
        return $this->render('crm/business/show.html.twig', [
            'business' => $business,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="crm_business_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Business $business): Response
    {
        $form = $this->createForm(BusinessType::class, $business);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('crm_business_index');
        }

        return $this->render('crm/business/edit.html.twig', [
            'business' => $business,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="crm_business_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Business $business): Response
    {
        if ($this->isCsrfTokenValid('delete'.$business->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($business);
            $entityManager->flush();
        }

        return $this->redirectToRoute('crm_business_index');
    }
}
