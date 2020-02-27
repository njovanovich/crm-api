<?php

namespace App\Controller;

use App\Entity\Crm\Util;
use App\Entity\Crm\Lead;
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
     * @Route("/addnew", name="event_new2", methods={"GET","POST"})
     */
    public function new2(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->new($request, Event::class, EventType::class);
    }

    /**
     * @Route("/addevents/{type}/{id}", name="event_add_to", methods={"GET"})
     */
    public function addEvents(Request $request): Response
    {
        $success = FALSE;
        $type = $request->get('type');
        $id = $request->get('id');
        $events = $request->get('events');

        $eventIds = explode(',', $events);

        $em = $this->getDoctrine()->getManager();
        $className = Util::getClassName($type);
        $repo = $em->getRepository($className);

        $eventRepo = $em->getRepository(Event::class);

        $object = $repo->find($id);

        try{
            foreach ($eventIds as $eventId) {
                $event = $eventRepo->find($eventId);
                $object->addEvent($event);
            }
            $em->persist($object);
            $em->flush();
            $success = TRUE;
        }catch(Exception $ex){
            $success = FALSE;
        }

        $returnArray = [
            "success" => $success,
        ];
        return new JsonResponse($returnArray);
    }

    /**
     * @Route("/fetchby/{type}/{id}", name="event_by_person", methods={"GET"})
     */
    public function eventsByType(Request $request): Response
    {
        $success = FALSE;
        $type = $request->get('type');
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        $className = Util::getClassName($type);
        $repo = $em->getRepository($className);

        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $inArray = [
            "className" => $className,
            "id" => $id,
            "property" => "events"
        ];

        // get pagination, where & sort
        if ($request) {
            $limit = [];
            $limit['start'] = $request->get('start') ?: 0;
            $limit['pageSize'] = $request->get('limit') ?: 12;

            $filter = json_decode($request->get('filter'), 1);
            $where = [];
            if ($filter) {
                foreach ($filter as $f) {
                    $where[$f['property']] = $f['value'];
                }

            }

            $sort = json_decode($request->get('sort'), 1);
            if ($sort) {
                $orderBy = [
                    $sort[0]["property"] => $sort[0]["direction"]
                ];
            } else {
                $orderBy = [];
            }
        } else {
            $limit = [];
            $limit['start'] = 0;
            $limit['pageSize'] = 12;
            $where = [];
            $orderBy = [];
        }

        $serializer = $this->container->get('serializer');

        try{
            $data = $base->findIn(Event::class, $inArray, $where, $limit, $orderBy);

            $objectsJson = $serializer->serialize($data['data'], "json");
            $objects = json_decode($objectsJson);

            $success = TRUE;
        }catch(Exception $ex){}

        $returnArray = [
            "data" => $objects,
            "success" => $success,
            "total" => $data["total"],
        ];
        return new JsonResponse($returnArray);
    }

    /**
     * @Route("/new/{type}/{id}", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $type = $request->get('type');
        $className = Util::getClassName($type);
        $repo = $entityManager->getRepository($className);

        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        $object = $repo->find($id);
        if ($object) {
            $object->addEvent($event);
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $event = $form->getData();

            $entityManager->persist($event);
            $entityManager->persist($object);
            $entityManager->flush();

            return new JsonResponse([
                'id' => $event->getId(),
                'success'=>true
            ]);
        }

        return new JsonResponse([
            'success'=>false,
        ], 400);
    }
}
