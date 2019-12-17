<?php

namespace App\Controller;

use App\Entity\Relationship;
use App\Form\RelationshipType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/relationship")
 */
class RelationshipController extends AbstractController
{
    /**
     * @Route("/", name="relationship_index", methods={"GET"})
     */
    public function index(): Response
    {
        $relationships = $this->getDoctrine()
            ->getRepository(Relationship::class)
            ->findAll();

        return $this->render('relationship/index.html.twig', [
            'relationships' => $relationships,
        ]);
    }

    /**
     * @Route("/new", name="relationship_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $relationship = new Relationship();
        $form = $this->createForm(RelationshipType::class, $relationship);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($relationship);
            $entityManager->flush();

            return $this->redirectToRoute('relationship_index');
        }

        return $this->render('relationship/new.html.twig', [
            'relationship' => $relationship,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="relationship_show", methods={"GET"})
     */
    public function show(Relationship $relationship): Response
    {
        return $this->render('relationship/show.html.twig', [
            'relationship' => $relationship,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="relationship_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Relationship $relationship): Response
    {
        $form = $this->createForm(RelationshipType::class, $relationship);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('relationship_index');
        }

        return $this->render('relationship/edit.html.twig', [
            'relationship' => $relationship,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="relationship_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Relationship $relationship): Response
    {
        if ($this->isCsrfTokenValid('delete'.$relationship->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($relationship);
            $entityManager->flush();
        }

        return $this->redirectToRoute('relationship_index');
    }
}
