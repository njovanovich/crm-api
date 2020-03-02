<?php

namespace App\Controller\Crm;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\BaseController;
/**
 * @Route("/report")
 */
class ReportController extends AbstractController
{
    /**
     * @Route("/leads", name="reports_leads", methods={"GET"})
     */
    public function leads(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $base->checkCsrf();
        $base->checkLogin();

        $em = $this->getDoctrine()->getManager();

        $dql = 'SELECT count(l), l.status from \App\Entity\Crm\Lead l GROUP BY l.status';

        $query = $em->createQuery($dql);

        $data = [
            ['Lead Type', 'Amount'],
        ];

        $result = $query->getArrayResult();

        foreach ($result as $row) {
            $data[] = [$row['status'] . " - " . $row['1'], (int)$row['1']];
        }

        $objects = [
            'data' => $data,
            "success" => TRUE
        ];

        return new JsonResponse($objects);
    }

    /**
     * @Route("/jobs", name="reports_jobs", methods={"GET"})
     */
    public function jobs(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $base->checkCsrf();
        $base->checkLogin();

        $em = $this->getDoctrine()->getManager();
        $serializer = $this->container->get('serializer');

        $dql = "SELECT j,l from \App\Entity\Crm\Job j JOIN j.lead l 
                    WHERE j.status = 'completed' AND j.completedDate != ''";

        $query = $em->createQuery($dql);

        $result = $query->getArrayResult();

        foreach ($result as $row) {
            $leadUpdated = $row['lead']['updated'];
            $jobCompleted = $row['completedDate'];
            $timeElapsed = $jobCompleted->diff($leadUpdated);
            $timeElapsedString = "";
            if ($y=$timeElapsed->y) {
                $timeElapsedString .= $y ."yrs ";
            }
            if ($m=$timeElapsed->m) {
                $timeElapsedString .= $m ."mths ";
            }
            $d=$timeElapsed->d;
            $timeElapsedString .= $d . "days ";
            $h=$timeElapsed->h;
            $timeElapsedString .= $h ."hrs ";
            $i=$timeElapsed->i;
            $timeElapsedString .= $i . "min ";

            $data[] = [
                "jobId" => $row['id'],
                "jobName" => $row['name'],
                "leadWon" => $leadUpdated,
                "jobCompleted" => $jobCompleted,
                "timeElapsed" => trim($timeElapsedString)
            ];
        }

        $serializedObject = $serializer->serialize($data, 'json');
        $outArray = json_decode($serializedObject);

        $objects = [
            'data' => $outArray,
            "success" => TRUE
        ];

        return new JsonResponse($objects);
    }

}
