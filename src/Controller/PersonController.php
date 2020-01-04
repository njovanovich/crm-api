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
     * @Route("/{id}", name="person_show", methods={"GET"})
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
     * @Route("/{id}", name="person_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Person $person): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->delete($request, $person, $token='');
    }

    /**
     * @Route("/{id}/addNote/{noteid}", name="person_addnote", methods={"POST"})
     */
    public function addnote(Request $request, Person $person): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Note::class);

        $noteObject = $repository->find($request->get('noteid'));

        if ($noteObject) {
            $person->addNote($noteObject);
            $entityManager->persist($person);
            $entityManager->persist($noteObject);
            $entityManager->flush();
        }

        return new JsonResponse(["success"=>true]);
    }

}
