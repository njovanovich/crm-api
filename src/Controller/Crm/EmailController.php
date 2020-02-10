<?php

namespace App\Controller\Crm;

use App\Entity\Crm\Email;
use App\Form\Crm\EmailType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/crm/email")
 */
class EmailController extends AbstractController
{
    /**
     * @Route("/", name="crm_email_index", methods={"GET"})
     */
    public function index(): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->index(Email::class);
    }

    /**
     * @Route("/new", name="crm_email_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->new($request, "App\Entity\Crm\Email", "App\Form\Crm\EmailType");
    }

    /**
     * @Route("/{id}", name="crm_email_show", methods={"GET"})
     */
    public function show(Email $email): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->show($email, Email::class);
    }

    /**
     * @Route("/{id}/edit", name="crm_email_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Email $email): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->edit($request, $email, EmailType::class);
    }

    /**
     * @Route("/{id}", name="crm_email_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Email $email): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->delete($request, $email, $token='');
    }
}
