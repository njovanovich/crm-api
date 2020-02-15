<?php

namespace App\Controller\Crm;

use App\Controller\BaseController;
use App\Entity\Crm\Contact;
use App\Form\Crm\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="crm_contact_index", methods={"GET"})
     */
    public function index(): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->index(Contact::class);
    }

    /**
     * @Route("/new", name="crm_contact_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->new($request, "App\Entity\Crm\Contact", "App\Form\Crm\ContactType");
    }

    /**
     * @Route("/{id}", name="crm_contact_show", methods={"GET"})
     */
    public function show(Contact $contact): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->show($contact, Contact::class);
    }

    /**
     * @Route("/{id}/edit", name="crm_contact_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Contact $contact): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->edit($request, $contact, ContactType::class);
    }

    /**
     * @Route("/{id}", name="crm_contact_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Contact $contact): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->delete($request, $contact, $token='');
    }
}
