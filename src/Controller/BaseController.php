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

    public const SEARCH_IN = "SEARCH_IN";
    public const SEARCH_DEEP = "SEARCH_DEEP";

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

    public function index($class, $flags=[]): Response
    {
        $request = $this->request;
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->container->get('serializer');

        // get pagination
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

        $data = $this->findBy($class, $where, $limit, $orderBy, $flags);

        $objects = $data['data'];

        $serializedObject = $serializer->serialize($objects, 'json');
        $objects = json_decode($serializedObject);

        $count = $data['count'];

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

        return new JsonResponse(['success'=>false], 400);
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

    /**
     * @param $className
     * @param array $where
     * @param array $limit
     * @param array $sort
     * @return array
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \ReflectionException
     */
    public function findBy($className, $where=[], $limit=[], $sort=[], $flags=[]){
        $em = $this->getDoctrine()->getManager();
        $classAnnotations = $this->getAnnotations($className);

        // flags
        $searchDeep = in_array(BaseController::SEARCH_DEEP, $flags);
        $searchIn = in_array(BaseController::SEARCH_IN, $flags);

        // create dql
        $firstSelector = "a";
        $selectorIndex = 0;
        $joinDql = "";
        $extraSelectors = [];
        $columns = [];
        $joinTables = [];
        foreach ($classAnnotations as $property=>$annotations) {
            $isJoin = FALSE;
            $joinClassName = "";
            foreach ($annotations as $annotation) {
                switch (get_class($annotation)) {
                    case @ORM\ManyToMany::class:
                        $isJoin = TRUE;
                        $joinClassName = $annotation->targetEntity;
                        break;
                    case @ORM\ManyToOne::class:
                        $isJoin = TRUE;
                        $joinClassName = $annotation->targetEntity;
                        break;
                    case @ORM\Column::class:
                        $columns[$firstSelector][$property] = $annotation;
                        break;
                }
            }
            if ($isJoin) {
                $extraSelector = chr(98 + $selectorIndex++);
                $joinDql .= " LEFT JOIN $firstSelector.$property $extraSelector \r\n";
                $extraSelectors[] = $extraSelector;
                $joinTables[$extraSelector] = [
                    "selector" => $extraSelector,
                    "className" => $joinClassName
                ];
            }
        }

        // do the extra tables if isDeep
        if ($searchDeep) {
            foreach ($joinTables as $extraSelector=>$joinTable) {
                $joinClassName = $joinTable['className'];
                $classAnnotations = $this->getAnnotations($joinClassName);
                foreach ($classAnnotations as $property=>$annotations) {
                    foreach ($annotations as $annotation) {
                        switch (get_class($annotation)) {
                            case @ORM\Column::class:
                                $columns[$extraSelector][$property] = $annotation;
                                break;
                        }
                    }
                }
            }
        }

        // start the dql
        $select = $firstSelector. "," . implode(',', $extraSelectors);
        $dql = "SELECT $select FROM $className AS $firstSelector ";
        $dql .= $joinDql;

        // build the where clause
        $whereSql = "";
        if (count($where)){
            $whereKeys = array_keys($where);
            $whereValues = array_values($where);
            $whereSqlArray = [];
            if ($whereKeys[0] == "all"){
                foreach($columns as $selector=>$column){
                    foreach($column as $property=>$field) {
                        if ($field->type == "string") {
                            $searchTerm = $whereValues[0] . "%";
                            if ($searchIn) {
                                $searchTerm = "%" . $whereValues[0] . "%";
                            }
                            $whereSqlArray[] = " $selector.$property LIKE '$searchTerm' ";;
                        }
                    }
                }
                $whereSql = implode(' OR ', $whereSqlArray);
            } else {
                // iterate over the columns until found in where
                foreach($columns as $selector=>$column){
                    foreach($column as $property=>$field) {
                        if (in_array($property, array_keys($where))) {
                            if ($value = $where[$property]) {
                                if ($field->type == "string") {
                                    $searchTerm = $value . "%";
                                    if ($searchIn) {
                                        $searchTerm = "%" . $value . "%";
                                    }
                                    $whereSqlArray[] = " $selector.$property LIKE '$value'";
                                } else if ($field->type == "integer") {
                                    $whereSqlArray[] = " $selector.$property = '$value'";
                                }
                            }
                        }
                    }
                }
                $whereSql = implode(' AND ', $whereSqlArray);
            }

            $dql .= " WHERE " . $whereSql;
        }
        if (count($sort)) {
            $sortArrayKeys = array_keys($sort);
            $dql .= " ORDER BY $firstSelector." . $sortArrayKeys[0] . " " . $sort[$sortArrayKeys[0]];
        }

        $query = $em->createQuery($dql);
        if (count($limit)){
            $start = $limit["start"];
            $pageSize = $limit["pageSize"];
            $query->setMaxResults($pageSize);
            $query->setFirstResult($start);
        }

        $objects = $query->getArrayResult();

        // get total
        $dql = "SELECT count($firstSelector) as count FROM $className $firstSelector $joinDql";
        if ($whereSql){
            $dql .= " WHERE $whereSql";
        }
        $query = $em->createQuery($dql);
        $countResult = $query->getArrayResult();
        $count = $countResult[0]['count'];

        return array("data"=>$objects, "count" => $count);
    }

    /**
     * @param $className
     * @param $inArray
     * @param array $where
     * @param array $limit
     * @param array $sort
     */
    public function findIn($className, $inArray, $where=[], $limit=[], $sort=[]){
        $em = $this->getDoctrine()->getManager();
        $request = $this->request;

        // get pagination
        if ($request) {
            // get limits
            $limit = [];
            $limit['start'] = $request->get('start') ?: 0;
            $limit['pageSize'] = $request->get('limit') ?: 12;

            // get filter
            $filter = json_decode($request->get('filter'), 1);
            $where = [];
            if ($filter) {
                foreach ($filter as $f) {
                    $where[$f['property']] = $f['value'];
                }

            }

            // get order by
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

        // get the "in" array
        $inClassName = $inArray["className"];
        $inId = $inArray["id"];
        $inClassProperty = $inArray["property"];

        // build where clause
        $columns = [];
        $propertyAnnotations = $this->getAnnotations($className);
        foreach ($propertyAnnotations as $property=>$annotations) {
            foreach ($annotations as $annotation) {
                switch (get_class($annotation)) {
                    case @ORM\Column::class:
                        $columns[$property] = $annotation;
                        break;
                }
            }
        }

        $whereKeys = array_keys($where);
        $isAll = (count($whereKeys) && $whereKeys[0] == 'all');
        $value = "";
        if ($isAll) {
            $value = $where['all'];
        }

        $whereSqlArray = [];
        $whereSql = "";
        foreach ($columns as $property=>$column){
            if ($isAll) {
                if ($column->type == "string") {
                    $whereSqlArray[] = " a.$property LIKE '" . $value . "%'";
                }
            } else {
                if (in_array($property,$where)) {
                    $value = $where[$property];
                    if ($column->type == "string") {
                        $whereSqlArray[] = " a." . $where[$property] . " LIKE '" . $value . "%'";
                    } else if ($column->type == "integer" || $column->type == "int") {
                        $whereSqlArray[] = " a." . $where[$property] . " = '" . $value . "'";
                    }
                }
            }
        }
        if (count($whereSqlArray)) {
            if ($isAll) {
                $whereSql = implode(' OR ', $whereSqlArray);
            } else {
                $whereSql = implode(' AND ', $whereSqlArray);
            }
        }

        $dql = "SELECT a 
                    FROM $className a 
                    WHERE a.id IN (
                        SELECT b.id 
                            FROM $inClassName c LEFT JOIN c.$inClassProperty b 
                        WHERE c.id = $inId
                    )";

        if ($whereSql) {
            $dql .= " AND ($whereSql)";
        }

        $query = $em->createQuery($dql);
        if (count($limit)){
            $start = $limit["start"];
            $pageSize = $limit["pageSize"];
            $query->setMaxResults($pageSize);
            $query->setFirstResult($start * $pageSize);
        }

        $objects = $query->getArrayResult();

        // get total
        $dql = str_replace("SELECT a", "SELECT count(a) as count ", $dql);
        $query = $em->createQuery($dql);
        $countResult = $query->getArrayResult();
        $count = $countResult[0]['count'];

        return [
            "total" => $count,
            "data" => $objects
        ];

    }

    private function getAnnotations($className){
        $propertyAnnotations = [];

        $reflectionClass = new \ReflectionClass($className);
        $properties = $reflectionClass->getProperties ();
        $reader = new AnnotationReader();

        foreach ($properties as $property) {
            $annotations = $reader->getPropertyAnnotations(
                $property
            );
            if ($annotations) {
                $propertyAnnotations[$property->getName()] = $annotations;
            }
        }
        return $propertyAnnotations;
    }
}