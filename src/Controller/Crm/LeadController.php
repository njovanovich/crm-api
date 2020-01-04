<?php

namespace App\Controller\Crm;

use App\Entity\Crm\Lead;
use App\Form\Crm\LeadType;
use App\Controller\BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/crm/lead")
 */
class LeadController extends AbstractController
{
    /**
     * @Route("/", name="crm_lead_index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $conn = $this->getDoctrine()->getConnection();

        $page = $request->get('page') ?? 1;
        $limit = (int)($request->get('limit') ?? 10);
        $start = (int)(($page-1) * $limit);
        $orderby = $request->get('sort') ?? 'id ASC';
        $sql = "SELECT *, leads.id as id, b.name as business_name, 
                    IF(p.last_name!='',concat(p.last_name,', ',p.first_name),p.first_name) as person_name,
                    p.email as person_email, p.phone as person_phone
                    FROM leads LEFT JOIN businesses b on business=b.id
                        LEFT JOIN people p on person=p.id
             ORDER BY :orderby
             LIMIT $start, $limit";

        $stmt = $conn->prepare($sql);
        $stmt->execute(['orderby' => $orderby]);
        $objects = array();
        $objects['data'] = $stmt->fetchAll();;

        $sql = "SELECT COUNT(*) as count FROM leads ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $countResult = $stmt->fetch();
        $count = $countResult['count'];
        $objects['total'] = $count;
        $objects['success'] = true;

        $response = new JsonResponse();
        $response->setData($objects);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
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
     * @Route("/{id}/edit", name="crm_lead_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Lead $lead): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->edit($request, $lead, LeadType::class);
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
