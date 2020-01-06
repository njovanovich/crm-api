<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Person;
use App\Form\AddressType;
use App\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="event_index", methods={"GET"})
     */
    public function index(): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->index(Event::class);
    }

    /**
     * @Route("/new/person/{id}", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(Person::class);

        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        $id = $request->get('id');
        $person = $repo->find($id);
        if ($person) {
            $event->addPerson($person);
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $event = $form->getData();

            $entityManager->persist($event);
            $entityManager->flush();

            return new JsonResponse([
                'id' => $event->getId(),
                'success'=>true
            ]);
        }

        return new JsonResponse(['success'=>false]);
    }

    /**
     * @Route("/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->show($event, Event::class);
    }

    /**
     * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->edit($request, $event, EventType::class);
    }

    /**
     * @Route("/{id}", name="event_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Event $event): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->delete($request, $event, $token='');
    }

    /**
     * @Route("/person/{id}/events", name="event_by_person", methods={"GET"})
     */
    public function eventsByPerson(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Event::class);
        $serializer = $this->container->get('serializer');

        $person_id = (int)$request->get('id');
        $dql = "SELECT e.id 
                    FROM events e LEFT JOIN person_events pe ON e.id=pe.event
                    WHERE pe.person=$person_id";

        $query = $em->createQuery($dql);
        $eventIds = $query->getArrayResult();

        $objects = [];
        foreach ($eventIds as $eventId) {
            $object = $repo->find($eventId);
            $serializedObject = $serializer->serialize($object, 'json');
            $objects[] = json_decode($serializedObject);
        }

        $returnArray = [
            "data" => $objects,
            "success" => true
        ];
        return new JsonResponse($returnArray);
    }
}