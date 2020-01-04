<?php

namespace App\Controller\Crm;

use App\Entity\Crm\Job;
use App\Form\Crm\JobType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/crm/job")
 */
class JobController extends AbstractController
{
    /**
     * @Route("/", name="crm_job_index", methods={"GET"})
     */
    public function index(): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->index(Job::class);
    }

    /**
     * @Route("/new", name="crm_job_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->new($request, "App\Entity\Event", "App\Form\EventType");
    }

    /**
     * @Route("/{id}", name="crm_job_show", methods={"GET"})
     */
    public function show(Job $job): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->show($job, Job::class);    }

    /**
     * @Route("/{id}/edit", name="crm_job_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Job $job): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->edit($request, $job, JobType::class);
    }

    /**
     * @Route("/{id}", name="crm_job_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Job $job): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->delete($request, $job, $token='');
    }
}
