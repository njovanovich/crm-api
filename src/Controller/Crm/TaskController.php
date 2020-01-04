<?php

namespace App\Controller\Crm;

use App\Entity\Crm\Task;
use App\Form\Crm\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/crm/task")
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/", name="crm_task_index", methods={"GET"})
     */
    public function index(): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->index(Task::class);
    }

    /**
     * @Route("/new", name="crm_task_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->new($request, Task::class, TaskType::class);
    }

    /**
     * @Route("/{id}", name="crm_task_show", methods={"GET"})
     */
    public function show(Task $task): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->show($task, Task::class);
    }

    /**
     * @Route("/{id}/edit", name="crm_task_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Task $task): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->edit($request, $task, TaskType::class);
    }

    /**
     * @Route("/{id}", name="crm_task_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Task $task): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->delete($request, $task, $token='');
    }
}
