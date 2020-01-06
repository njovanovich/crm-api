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

use App\Entity\Person;

class BaseController extends AbstractController
{

    public function __construct()
    {
    }

    public function index($class, int $start=0, int $pageSize=10, $where=[]): Response
    {
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT c FROM $class c ";
        if ($where) {
            $dql .= "WHERE $where ";
        }

        $query = $em->createQuery($dql);
        if(count($where)){
            foreach ($where as $k=>$v) {
                $query->setParameter($k, $v);
            }
        }

        $query->setFirstResult($start)
                ->setMaxResults($pageSize);
        $objects = $query->getArrayResult();

        // get total
        $dql = "SELECT count(c) as count FROM $class c ";
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