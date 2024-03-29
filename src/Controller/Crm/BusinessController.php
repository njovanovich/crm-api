<?php

namespace App\Controller\Crm;

use App\Entity\Crm\Business;
use App\Entity\Crm\Lead;
use App\Entity\Crm\Note;
use App\Form\Crm\BusinessType;
use App\Controller\BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/business")
 */
class BusinessController extends AbstractController
{
    /**
     * @Route("/", name="crm_business_index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        return $base->index(Business::class);
    }

    /**
     * @Route("/new", name="crm_business_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        return $base->new($request, "App\Entity\Crm\Business", "App\Form\Crm\BusinessType");
    }

    /**
     * @Route("/{id}", name="crm_business_show", methods={"GET"})
     */
    public function show(Business $business, Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        return $base->show($business, Business::class);
    }

    /**
     * @Route("/{id}/edit", name="crm_business_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Business $business): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        return $base->edit($request, $business, BusinessType::class);
    }

    /**
     * @Route("/{id}", name="crm_business_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Business $business): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        return $base->delete($request, $business, $token='');
    }

    /**
     * @Route("/searchby/{searchField}/{searchTerm}", name="crm_business_find_by", methods={"GET"})
     */
    public function findBy(Request $request): Response
    {

        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $base->checkCsrf();
        $base->checkLogin();

        $entityManager = $this->getDoctrine()->getManager();
        $qb = $entityManager->createQueryBuilder();
        $searchField = $request->get('searchField');
        $searchTerm = $request->get('searchTerm');

        $qb->select('b','n');

        // build from & joins
        $qb->from(Business::class, 'b');
        $qb->leftJoin('b.notes', 'n');

        $searchFieldNoDot = $searchField;
        if (strpos($searchFieldNoDot, '.') !== FALSE){
            $searchFieldNoDot = explode('.',$searchField)[1];
        }
        $qb->orWhere($searchField.' LIKE :' . $searchFieldNoDot);
        $qb->setParameter($searchFieldNoDot, $searchTerm.'%');

        // get the data
        $query = $qb->getQuery();
        $data = $query->getArrayResult();

        $outArray = [
            'success'=>true,
            'data' => $data
        ];
        return new JsonResponse($outArray);
    }

    /**
     * @Route("/search/{searchTerm}", name="crm_business_search", methods={"GET"})
     */
    public function search(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $qb = $entityManager->createQueryBuilder();
        $searchTerm = $request->get('searchTerm');

        $qb->select('b');

        // build from & joins
        $qb->from(Business::class, 'b');

        $fields = ['name','abn'];

        foreach ($fields as $field) {
            $qb->orWhere("b.$field LIKE :" . $field);
            $qb->setParameter($field, $searchTerm.'%');
        }

        $qb->orderBy("b.name", "ASC");

//        if (count($limitInfo)) {
//            $offset = $limitInfo['offset'];
//            $limit = $limitInfo['limit'];
//            $qb->setFirstResult( $offset )
//                ->setMaxResults( $limit );
//        }

        // get the data
        $query = $qb->getQuery();
        $data = $query->getArrayResult();

        $outArray = [
            'success'=>true,
            'data' => $data
        ];
        return new JsonResponse($outArray);
    }

    /**
    * @Route("/create/{name}", name="crm_business_create", methods={"POST"})
    */
    public function create(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->container->get('serializer');

        $success = false;
        $data = [];

        try{
            $name = $request->get('name');

            $business = new Business();
            $business->setName($name);

            $em->persist($business);
            $em->flush();

            $serializedObject = $serializer->serialize($business, 'json');
            $data = json_decode($serializedObject);

        }catch(Exception $ex){}

        $outArray = [
            'success'=>$success,
            'data' => $data
        ];
        return new JsonResponse($outArray);
    }

}
