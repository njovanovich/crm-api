<?php

namespace App\Controller\Crm;

use App\Entity\Crm\Note;
use App\Controller\BaseController;
use App\Entity\Crm\Util;
use App\Entity\Crm\User;
use App\Form\Crm\NoteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/note")
 */
class NoteController extends AbstractController
{
    /**
     * @Route("/", name="crm_note_index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        return $base->index(Note::class);
    }

    /**
     * @Route("/new", name="crm_note_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $base->checkLogin();
        $base->checkCsrf();

        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        // set user
        try{
            $session = new Session();
            $userId = $session->get('userId');
            $userRepo = $this->getDoctrine()->getRepository(User::class);
            $user = $userRepo->find($userId);
            $note->setCreatedBy($user);
        }catch(\Exception $ex){
        }

        $serializer = $this->container->get('serializer');

        if ($form->isSubmitted() && $form->isValid()) {

            $object = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($object);
            $entityManager->flush();

            $data = [$object];

            $serializedObject = $serializer->serialize($data, 'json');
            $objectSerialised = json_decode($serializedObject);

            try{
                unset($objectSerialised[0]->createdBy->password);
            }catch(\Exception $ex){}


            return new JsonResponse([
                'id' => $object->getId(),
                'data' => $objectSerialised,
                'success'=>true
            ]);
        }

        return new JsonResponse(['success'=>false], 400);
    }

    /**
     * @Route("/{id}", name="crm_note_show", methods={"GET"})
     */
    public function show(Note $note, Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $base->checkLogin();
        $base->checkCsrf();

        return $base->show($note, Note::class);
    }

    /**
     * @Route("/{id}/edit", name="crm_note_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Note $note): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $base->checkLogin();
        $base->checkCsrf();

        return $base->edit($request, $note, NoteType::class);
    }

    /**
     * @Route("/{id}", name="crm_note_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Note $note): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        return $base->delete($request, $note, $token='');
    }

    /**
     * @Route("/addNote/{type}/{id}", name="crm_add_note", methods={"POST","GET"})
     */
    public function addNote(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $base->checkLogin();
        $base->checkCsrf();

        $success = FALSE;

        $note = new Note();
        $contents = $request->get('contents');
        $note->setContents($contents);

        // set user
        try{
            $session = new Session();
            $userId = $session->get('userId');
            $userRepo = $this->getDoctrine()->getRepository(User::class);
            $user = $userRepo->find($userId);
            $note->setCreatedBy($user);
        }catch(\Exception $ex){
        }

        try{
            $type = $request->get('type');
            $class = Util::getClassName($type);
            if ($class) {
                $repo = $this->getDoctrine()->getRepository($class);
                $object = $repo->find($request->get('id'));
                if ($object) {
                    $object->addNote($note);
                    $entityManager->persist($object);
                }
                $success = TRUE;
            }
        }catch(Exception $ex){}

        $entityManager->persist($note);
        $entityManager->flush();

        return new JsonResponse([
            'success'=>$success
        ]);
    }

    /**
     * @Route("/addnotes/{type}/{id}", name="note_add_to", methods={"GET"})
     */
    public function addNotes(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $base->checkLogin();
        $base->checkCsrf();

        $success = FALSE;
        $type = $request->get('type');
        $id = $request->get('id');
        $notes = $request->get('notes');

        $noteIds = explode(',', $notes);

        $em = $this->getDoctrine()->getManager();
        $className = Util::getClassName($type);
        $repo = $em->getRepository($className);

        $noteRepo = $em->getRepository(Note::class);

        $object = $repo->find($id);

        try{
            foreach ($noteIds as $noteId) {
                $note = $noteRepo->find($noteId);
                $object->addNote($note);

            }
            $em->persist($object);
            $em->flush();
            $success = TRUE;
        }catch(Exception $ex){
            $success = FALSE;
        }

        $returnArray = [
            "success" => $success,
        ];
        return new JsonResponse($returnArray);
    }


    /**
     * @Route("/getNotes/{type}/{id}", name="crm_get_notes_type", methods={"GET"})
     */
    public function getNotes(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $base->checkLogin();
        $base->checkCsrf();

        $entityManager = $this->getDoctrine()->getManager();
        $type = $request->get('type');
        $id = $request->get('id');
        $notes = [];
        try{
            $class = Util::getClassName($type);

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

    /**
     * @Route("/search/{id}/{type}/{phrase}", name="crm_search_notes", methods={"GET"})
     */
    public function searchNotes(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $base->checkLogin();
        $base->checkCsrf();

        $entityManager = $this->getDoctrine()->getManager();

        $success = false;
        $type = $request->get('type');
        $id = $request->get('id');
        $searchTerm = $request->get('phrase');
        $outNotes = [];
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
                case "lead":
                    $class = "App\Entity\Crm\Lead";
                    break;
                case "quote":
                    $class = "App\Entity\Crm\Quote";
                    break;
                case "business":
                    $class = "App\Entity\Crm\Business";
                    break;
            }
            if ($class) {
                $repo = $this->getDoctrine()->getRepository($class);
                $object = $repo->find($id);
                $notes = $object->getNotes()->getValues();
                $serializer = $this->container->get('serializer');
                foreach ($notes as $k=>$note) {
                    $contents = $note->getContents();
                    if (strpos($contents, $searchTerm) !== FALSE) {
                        $serializedObject = $serializer->serialize($note, 'json');
                        $note = json_decode($serializedObject);
                        $outNotes[] = $note;
                    } else {
                        unset($notes[$k]);
                    }
                }
                $success = TRUE;
            }
        }catch(Exception $ex){}

        return new JsonResponse([
            'data' => $outNotes,
            'success'=>$success
        ]);

    }
}
