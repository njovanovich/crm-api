<?php

namespace App\Controller;

use App\Entity\Person;
use App\Entity\Crm\Note;
use App\Form\PersonType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/person")
 */
class PersonController extends AbstractController
{
    /**
     * @Route("/", name="person_index", methods={"GET"})
     */
    public function index(): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->index(Person::class);
    }

    /**
     * @Route("/new", name="person_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->new($request, "App\Entity\Person", "App\Form\PersonType");
    }

    /**
     * @Route("/{id}", name="person_show", methods={"GET"}, requirements={"id":"\d+"})
     */
    public function show(Person $person): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->show($person, Person::class);
    }

    /**
     * @Route("/{id}/edit", name="person_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Person $person): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->edit($request, $person, PersonType::class);
    }

    /**
     * @Route("/{id}", name="person_delete", methods={"DELETE"},  requirements={"id":"\d+"})
     */
    public function delete(Request $request, Person $person): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->delete($request, $person, $token='');
    }

    /**
     * @Route("/{id}/addNote", name="person_addnote", methods={"POST"})
     */
    public function addnote(Request $request, Person $person): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $note = new Note();
        $note->setContents($request->get('contents'));

        if ($note) {
            $entityManager->persist($note);
            $entityManager->flush();
            $person->addNote($note);
            $entityManager->persist($person);
            $entityManager->flush();
        }

        return new JsonResponse(["success"=>true]);
    }

}
