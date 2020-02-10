<?php
/**
 * BaseController.php
 * Created by: nick
 * @ 20/12/2019 4:40 pm
 * Project: crm
 *
 * Copyright © 2019 Total Business Information Solutions Pty Ltd
 *
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;

class BaseController extends AbstractController
{

    private $session;
    private $csrfToken;
    private $request;

    public function __construct(/*Request $request*/)
    {
        $this->session = new Session();
        //$this->session->start();
        $this->csrfToken = $this->session->get('csrf');
        //$this->request = $request;
    }

    public function index($class, int $start=0, int $pageSize=12, $where=[], $orderBy=null): Response
    {
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->container->get('serializer');
        $repo = $em->getRepository($class);

        // hack for serializer
        if ($class != "App\\Entity\\Crm\\Quote")  {
            $objects = $repo->findBy($where, $orderBy, $pageSize, $start);
        } else {
            $dql = "SELECT c, b, p FROM $class c 
                             JOIN c.business b
                             JOIN c.person p";
            if ($where){
                $dql .= " WHERE $where";
            }
            $query = $em->createQuery($dql);
            $objects = $query->getArrayResult();
        }
        $serializedObject = $serializer->serialize($objects, 'json');
        $objects = json_decode($serializedObject);

        // get total
        $dql = "SELECT count(c) as count FROM $class c";
        if ($where){
            $dql .= " WHERE $where";
        }
        $query = $em->createQuery($dql);
        $countResult = $query->getArrayResult();
        $count = $countResult[0]['count'];

        $response = new JsonResponse();
        $returnArray = [
            'data' => $objects,
            'success' => true,
            'total' => $count
        ];
        $response->setData($returnArray);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function new(Request $request, $class, $classType): Response
    {
        $object = new $class();
        $form = $this->createForm($classType, $object);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $object = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($object);
            $entityManager->flush();

            return new JsonResponse([
                'id' => $object->getId(),
                'success'=>true
            ]);
        }

        return new JsonResponse(['success'=>false]);
    }

    public function show($object, $class, $token=''): Response
    {
        $serializer = $this->container->get('serializer');
        $serializedObject = $serializer->serialize($object, 'json');
        $responseData = [
            'data' => [json_decode($serializedObject)],
            'success' => true
        ];
        $response = new JsonResponse();
        $response->setData($responseData);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function edit(Request $request, $object, $objectFormClass, $token=''): Response
    {
        $form = $this->createForm($objectFormClass, $object);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($object);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(['success'=>true]);
        }

        return new JsonResponse(['success'=>false]);
    }

    public function delete(Request $request, $object, $token=''): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($object);
        $entityManager->flush();

        return new JsonResponse(['success'=>true]);
    }


}