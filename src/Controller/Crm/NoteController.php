<?php

namespace App\Controller\Crm;

use App\Entity\Crm\Note;
use App\Controller\BaseController;
use App\Form\Crm\NoteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    /**
     * @Route("/addNote/{type}/{id}", name="crm_add_note", methods={"POST","GET"})
     */
    public function addNote(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $note = new Note();
        $contents = $request->get('contents');
        $note->setContents($contents);

        try{
            $type = $request->get('type');
            $class = "";
            switch($type){
                case "person":
                    $class = "App\Entity\Person";
                    break;
                case "event":
                    $class = "App\Entity\Event";
                    break;
                case "call":
                    $class = "App\Entity\Crm\Call";
                    break;
            }
            if ($class) {
                $repo = $this->getDoctrine()->getRepository($class);
                $object = $repo->find($request->get('id'));
                if ($object) {
                    $object->addNote($note);
                    $entityManager->persist($object);
                }
            }
        }catch(Exception $ex){}

        $entityManager->persist($note);
        $entityManager->flush();

        return new JsonResponse([
            'success'=>true
        ]);
    }

    /**
     * @Route("/getNotes/{type}/{id}", name="crm_note_delete", methods={"POST","GET"})
     */
    public function getNotes(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $type = $request->get('type');
        $id = $request->get('id');
        $notes = [];
        try{
            $class = "";
            switch($type){
                case "person":
                    $class = "App\Entity\Person";
                    break;
                case "event":
                    $class = "App\Entity\Event";
                    break;
                case "call":
                    $class = "App\Entity\Crm\Call";
                    break;
            }
            if ($class) {
                $repo = $this->getDoctrine()->getRepository($class);
                $object = $repo->find($id);
                $notes = $object->getNotes()->getValues();
                $serializer = $this->container->get('serializer');
                foreach ($notes as $k=>$note) {
                    $serializedObject = $serializer->serialize($note, 'json');
                    $notes[$k] =  json_decode($serializedObject);
                }


            }
        }catch(Exception $ex){}

        return new JsonResponse([
            'data' => $notes,
            'success'=>true
        ]);
    }


}
