<?php

namespace App\Controller\Crm;

use App\Entity\Crm\Task;
use App\Entity\Crm\User;
use App\Form\Crm\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/crm/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="crm_user_index", methods={"GET"})
     */
    public function index(): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->index(User::class);
    }

    /**
     * @Route("/new", name="crm_user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->new($request, User::class, UserType::class);
    }

    /**
     * @Route("/{id}", name="crm_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->show($user, User::class);
    }

    /**
     * @Route("/{id}/edit", name="crm_user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->edit($request, $user, UserType::class);
    }

    /**
     * @Route("/{id}", name="crm_user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->delete($request, $user, $token='');
    }
}
