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
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping as ORM;

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

    public function setRequest($request){
        $this->request = $request;
    }

    public function index($class): Response
    {
        $request = $this->request;
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->container->get('serializer');

        // get pagination
        if ($request) {
            $filter = json_decode($request->get('filter'), 1);

            $start = $request->get('start') ?: 0;
            $pageSize = $request->get('limit') ?: 12;

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
            $start = 0;
            $pageSize = 12;
            $where = [];
            $orderBy = [];
        }

        $reflectionClass = new \ReflectionClass($class);
        $properties = $reflectionClass->getProperties ();
        $reader = new AnnotationReader();
        $propertyAnnotations = [];
        foreach ($properties as $property) {
            $annotations = $reader->getPropertyAnnotations(
                $property
            );
            if ($annotations) {
                $propertyAnnotations[$property->getName()] = $annotations;
            }
        }

        // create dql
        $firstSelector = "a";
        $selectorIndex = 0;
        $joinDql = "";
        $extraSelectors = [];
        $columns = [];
        foreach ($propertyAnnotations as $property=>$annotations) {
            $isJoin = FALSE;
            foreach ($annotations as $annotation) {
                switch (get_class($annotation)) {
                    case @ORM\ManyToMany::class:
                        $isJoin = TRUE;
                        break;
                    case @ORM\ManyToOne::class:
                        $isJoin = TRUE;
                        break;
                    case @ORM\Column::class:
                        $columns[$property] = $annotation;
                        break;
                }
            }
            if ($isJoin) {
                $extraSelector = chr(98 + $selectorIndex++);
                $joinDql .= " LEFT JOIN $firstSelector.$property $extraSelector ";
                $extraSelectors[] = $extraSelector;
            }

        }
        $select = $firstSelector. "," . implode(',', $extraSelectors);
        $dql = "SELECT $select FROM $class AS $firstSelector ";
        $dql .= $joinDql;

        // build the where clause
        $whereSql = "";
        if ($where){
            $whereKeys = array_keys($where);
            $whereValues = array_values($where);
            $whereSqlArray = [];
            if ($whereKeys[0] == "all"){
                foreach($columns as $property=>$column) {
                    if ($column->type == "string") {
                        $whereSqlArray[] = " $firstSelector.$property LIKE '" . $whereValues[0] . "%'";;
                    }
                }
                $whereSql = implode(' OR ', $whereSqlArray);
            } else {
                foreach ($where as $key=>$value) {
                    $whereSqlArray[] = " $firstSelector." .$key . " LIKE '" . $value . "%'";
                }
                $whereSql = implode(' AND ', $whereSqlArray);
            }

            $dql .= " WHERE " . $whereSql;
        }
        if (count($orderBy)) {
            $dql .= " ORDER BY " . $sort[0]["property"] . " " . $sort[0]["direction"];
        }

        $query = $em->createQuery($dql);
        $objects = $query->getArrayResult();

        $serializedObject = $serializer->serialize($objects, 'json');
        $objects = json_decode($serializedObject);

        // get total
        $dql = "SELECT count($firstSelector) as count FROM $class $firstSelector";
        if ($whereSql){
            $dql .= " WHERE $whereSql";
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

        return new JsonResponse(['success'=>false], 400);
    }

    public function delete(Request $request, $object, $token=''): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($object);
        $entityManager->flush();

        return new JsonResponse(['success'=>true]);
    }

    public function complexLike($classNames, $searchBy, $joinInfo=[], $limitInfo=[], $orderBy=[]){
        $entityManager = $this->getDoctrine()->getManager();
        $qb = $entityManager->createQueryBuilder();

        $searchByKeys = array_keys($searchBy);
        $searchByValues = array_values($searchBy);

        $classNameKeys = array_keys($classNames);
        $mainClassKey =  $classNameKeys[0][0];
        $qb->select($classNameKeys);

        // build from & joins
        $counter = 0;
        foreach ($classNames as $key=>$className) {
            if (!$counter){
                $qb->from($className, $key);
            } else {
                if (!$joinInfo[$key]) {
                    throw new \Exception('Cannot find join info.');
                }
                $qb->leftJoin($className, $key, $joinInfo[$key]['conditionType'], $joinInfo[$key]['condition']);
            }
            $counter++;
        }

        foreach ($searchByKeys as $searchByKey) {
            $searchByKey2 = explode('.', $searchByKey)[1];
            $qb->orWhere($searchByKey.' LIKE :' . $searchByKey2);
        }
        for ($i = 0; $i < count($searchByKeys); $i++) {
            $searchByKey = $searchByKeys[0];
            $searchByKey = explode('.', $searchByKey)[1];
            $searchByValue = $searchByValues[0];
            $qb->setParameter($searchByKey, $searchByValue.'%');
        }

        if (count($orderBy)) {
            foreach ($orderBy as $key=>$dir) {
                $qb->orderBy($key, $dir);
            }
        }
        if (count($limitInfo)) {
            $offset = $limitInfo['offset'];
            $limit = $limitInfo['limit'];
            $qb->setFirstResult( $offset )
                ->setMaxResults( $limit );
        }

        // get the data
        $query = $qb->getQuery();
        $data = $query->getArrayResult();

        $outArray = [
            'success'=>true,
            'data' => $data
        ];
        return new JsonResponse($outArray);
    }


}