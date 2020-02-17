<?php

namespace App\Controller;

use App\Entity\Crm\Util;
use App\Entity\Event;
use App\Entity\Person;
use App\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

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
     * @Route("/fetchby/{type}/{id}", name="event_by_person", methods={"GET"})
     */
    public function eventsByType(Request $request): Response
    {
        $success = FALSE;
        $em = $this->getDoctrine()->getManager();
        $type = $request->get('type');
        $className = Util::getClassName($type);
        $repo = $em->getRepository($className);

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], [$encoder]);

        $typeObject = $repo->find($request->get('id'));

        try{
            $objects = array();
            foreach ($typeObject->getEvents() as $object) {
                $serializedObject = $serializer->serialize($object, 'json');
                $objects[] = json_decode($serializedObject);
            }
            $success = TRUE;
        }catch(Exception $ex){}

        $returnArray = [
            "data" => $objects,
            "success" => $success
        ];
        return new JsonResponse($returnArray);
    }

    /**
     * @Route("/new/{type}/{id}", name="event_new", methods={"GET","POST"})
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
            $person->addEvent($event);
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $event = $form->getData();

            $entityManager->persist($event);
            $entityManager->persist($person);
            $entityManager->flush();

            return new JsonResponse([
                'id' => $event->getId(),
                'success'=>true
            ]);
        }

        return new JsonResponse([
            'success'=>false,
            'errors' => (string)$form->getErrors(true)
        ]);
    }
}
