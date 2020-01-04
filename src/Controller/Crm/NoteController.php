<?php

namespace App\Controller\Crm;

use App\Entity\Crm\Note;
use App\Controller\BaseController;
use App\Form\Crm\NoteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/crm/note")
 */
class NoteController extends AbstractController
{
    /**
     * @Route("/", name="crm_note_index", methods={"GET"})
     */
    public function index(): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->index(Note::class);
    }

    /**
     * @Route("/new", name="crm_note_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->new($request, Note::class, NoteType::class);
    }

    /**
     * @Route("/{id}", name="crm_note_show", methods={"GET"})
     */
    public function show(Note $note): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->show($note, Note::class);
    }

    /**
     * @Route("/{id}/edit", name="crm_note_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Note $note): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->edit($request, $note, NoteType::class);
    }

    /**
     * @Route("/{id}", name="crm_note_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Note $note): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        return $base->delete($request, $note, $token='');
    }
}
