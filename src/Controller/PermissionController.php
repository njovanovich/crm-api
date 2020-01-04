<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Permission;
use App\Form\PermissionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/permission")
 */
class PermissionController extends AbstractController
{
    /**
     * @Route("/", name="permission_index", methods={"GET"})
     */
    public function index(): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->index(Permission::class);
    }

    /**
     * @Route("/new", name="permission_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->new($request, "App\Entity\Permission", "App\Form\PermissionType");
    }

    /**
     * @Route("/{id}", name="permission_show", methods={"GET"})
     */
    public function show(Permission $permission): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->show($permission, Permission::class);
    }

    /**
     * @Route("/{id}/edit", name="permission_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Permission $permission): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->edit($request, $permission, PermissionType::class);
    }

    /**
     * @Route("/{id}", name="permission_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Permission $permission): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->delete($request, $permission, $token='');
    }
}
