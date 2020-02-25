<?php

namespace App\Controller\Crm;

use App\Entity\Crm\Lead;
use App\Entity\Person;
use App\Form\Crm\LeadType;
use App\Controller\BaseController;
use Doctrine\ORM\Query\Expr\Base;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/lead")
 */
class LeadController extends AbstractController
{

    /**
     * @Route("/", name="crm_lead_index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        return $base->index(Lead::class, [BaseController::SEARCH_DEEP]);
    }

    /**
     * @Route("/new", name="crm_lead_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;

        return $base->new($request, Lead::class, LeadType::class);
    }

    /**
     * @Route("/{id}", name="crm_lead_show", methods={"GET"})
     */
    public function show(Lead $lead): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->show($lead, Lead::class);
    }

    /**
     * @Route("/details/{id}", name="crm_lead_details", methods={"GET"})
     */
    public function details(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $id = $request->get('id');

        $dql = 'SELECT l,p,b,q,j from App\Entity\Crm\Lead l
                        LEFT JOIN App\Entity\Person p WITH p.id=l.person
                        LEFT JOIN App\Entity\Crm\Business b WITH b.id=l.business
                        LEFT JOIN App\Entity\Crm\Quote q WITH l.id=q.lead
                        LEFT JOIN App\Entity\Crm\Job j WITH l.id=j.lead
                WHERE l.id=' .$id;

        $query = $em->createQuery($dql);
        $objects = $query->getArrayResult();

        if (count($objects)) {
            try{
                $outArray = [];
                $outArray["lead_id"] = $objects[0]["id"];
                $outArray["lead_person"] = $objects[1];
                $outArray["lead_business"] = $objects[2];
                $outArray["lead_status"] = $objects[0]["status"];
                $outArray["lead_amount"] = $objects[0]["amount"];

                if ($objects[3]) {
                    $outArray["quote_business"] = $objects[2];
                    $outArray["quote_quoteId"] = $objects[3]["quoteId"];
                    $outArray["quote_total"] = $objects[3]["total"];
                }

                if ($objects[4]) {
                    $outArray["job_business"] = $objects[2];
                    $outArray["job_jobId"] = $objects[4]["jobId"];
                    $outArray["job_name"] = $objects[4]["name"];
                    $outArray["job_status"] = $objects[4]["status"];
                    $outArray["job_completedDate"] = $objects[4]["completedDate"];
                    $outArray["job_deliveryDate"] = $objects[4]["deliveryDate"];
                }

            }catch(Exception $exception){}
        }

        $objects = [];
        $objects['data'] = $outArray;
        $objects['success'] = TRUE;

        $response = new JsonResponse();
        $response->setData($objects);
        return $response;
    }

    /**
     * @Route("/my/leads", name="crm_lead_mine", methods={"GET"})
     */
    public function myleads(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();


        $dql = 'SELECT l,p,b FROM App\Entity\Crm\Lead l
                        LEFT JOIN l.person p
                        LEFT JOIN l.business b
                    WHERE l.status = \'new\'';
        $query = $em->createQuery($dql)
            ->setFirstResult($request->get('start'))
            ->setMaxResults($request->get('limit'));

        $arrayList = $query->getArrayResult();

        $dql = 'SELECT count(l) as count FROM App\Entity\Crm\Lead l
                    WHERE l.status = \'new\'';
        $query = $em->createQuery($dql);
        $total = $query->getScalarResult();

        $objects = [];
        $objects['data'] = $arrayList;
        $objects['total'] = $total[0]['count'];
        $objects['success'] = TRUE;

        $response = new JsonResponse();
        $response->setData($objects);
        return $response;
    }

    /**
     * @Route("/{id}/edit", name="crm_lead_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Lead $lead): Response
    {
        $base = new BaseController();
        $base->container = $this->container;

        $em = $this->getDoctrine()->getManager();

        $person = $request->get("person");
        if (!is_numeric($person)) {
            $name = $person;
            $names = explode(' ', $name);
            $firstName = implode(" ",array_slice ($names, 0, count($names) - 2));
            $lastName = $names[count($names) - 1];

            $person = new Person();
            $person->setFirstName($firstName);
            $person->setLastName($lastName);

            $em->persist($person);
            $em->flush();
        }

        return $base->edit($request, $lead, LeadType::class);
    }

    /**
     * @Route("/{id}/editstatus", name="crm_lead_edit_status", methods={"POST"})
     */
    public function editstatus(Request $request, Lead $lead): Response
    {
        $success = FALSE;
        $em = $this->getDoctrine()->getManager();

        $status = $request->get('status');
        try{
            $objects = [];
            $lead->setStatus($status);
            $em->persist($lead);
            $em->flush();
            $success = TRUE;
        }catch(Exception $exception){}

        $objects['success'] = $success;
        $response = new JsonResponse();
        $response->setData($objects);
        return $response;
    }

    /**
     * @Route("/{id}", name="crm_lead_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Lead $lead): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->delete($request, $lead, $token='');
    }
}
