<?php

namespace App\Controller\Crm;

use App\Entity\Crm\User;
use App\Entity\Crm\Util;
use App\Form\Crm\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Controller\BaseController;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="crm_user_index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        return $base->index(User::class);
    }

    /**
     * @Route("/new", name="crm_user_new", methods={"GET","POST"})
     */
    public function new(Request $request, \Swift_Mailer $mailer): Response
    {
        $object = new User();
        $form = $this->createForm(UserType::class, $object);
        $form->handleRequest($request);

        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $base->checkCsrf();
        $base->checkLogin();


        $serializer = $this->container->get('serializer');

        if ($form->isSubmitted() && $form->isValid()) {

            $object = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($object);
            $entityManager->flush();

            $data = [$object];

            $serializedObject = $serializer->serialize($data, 'json');
            $objectSerialised = json_decode($serializedObject);
            unset($objectSerialised[0]->password);

            $url = Util::getSetting("url");

            $email = $object->getEmail();
            $password = $_REQUEST['user']['password'];
            $body = "";
            if ($url) {
                $body = "Website: $url <br><br>";
            }
            $body .= "Your new login credentials are: <br> 
                    Email: $email <br>
                    Password: $password <br>
                    ";
            $message = (new \Swift_Message('User created'))
                ->setFrom('system@leadcrm.com.au')
                ->setTo($email)
                ->setBody($body,'text/html')
            ;
            $mailer->send($message);

            return new JsonResponse([
                'id' => $object->getId(),
                'data' => $objectSerialised,
                'success' => true
            ]);
        }

        return new JsonResponse(['success' => false], 400);
    }

    /**
     * @Route("/{id}/edit", name="crm_user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        return $base->edit($request, $user, UserType::class);
    }

    /**
     * @Route("/{id}", name="crm_user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        return $base->delete($request, $user, $token = '');
    }

    /**
     * @Route("/login/status", name="user_login_status", methods={"GET"})
     */
    public function loginStatus(Request $request): Response
    {
        $session = new Session();
        $data = [
            "isLoggedIn" => FALSE,
            "success" => TRUE,
        ];
        if ($email=$session->get('email')) {
            $data["isLoggedIn"] = TRUE;
        }
        return new JsonResponse($data);
    }

    /**
     * @Route("/password/reset", name="user_password_reset", methods={"POST"})
     */
    public function passwordReset(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);

        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $base->checkLogin();
        $base->checkCsrf();

        $data = ['success' => FALSE];

        $session = new Session();
        $email = $session->get('email');

        $password = $request->get('password');

        $user = $repo->findBy(["email"=>$email]);
        if ($user && $user[0]) {
            $user = $user[0];
            $user->setPassword($password);
            $user->setResetPassword(0);
            $em->persist($user);
            $em->flush();
            $data['success'] = TRUE;
        }

        return new JsonResponse($data);

    }

        /**
     * @Route("/password/reminder", name="user_password_reminder", methods={"POST"})
     */
    public function passwordReminder(Request $request, \Swift_Mailer $mailer): Response
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);

        $data = ['success'=>FALSE];

        $email = $request->get('email');

        $user = $repo->findBy(["email"=>$email]);
        if ($user && $user[0]) {
            $user = $user[0];
            $password = bin2hex(random_bytes(10));
            $user->setPassword($password);
            $user->setResetPassword(1);
            $em->persist($user);
            $em->flush();

            $url = Util::getSetting("url");

            $body = "";
            if ($url) {
                $body = "Website: $url <br><br>";
            }
            $body .= "Your new login credentials are: <br> 
                    Email: $email <br>
                    Password: $password <br>
                    Please reset this on login.
                    ";

            $message = (new \Swift_Message('Password reset'))
                ->setFrom('system@leadcrm.com.au')
                ->setTo($email)
                ->setBody($body, 'text/html')
            ;
            $mailer->send($message);
            $data = ['success'=> TRUE];
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/login", name="user_login", methods={"POST"})
     */
    public function login(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);

        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $base->checkCsrf();

        $password = $request->get('password');
        $email = $request->get('email');

        $data = [
            "message" => "Bad email / password combination.",
            "success" => FALSE,
        ];

        $user = $repo->findBy(["email"=>$email]);
        if ($user && $user[0]) {
            $user = $user[0];
            $encryptedPassword = $user->getPassword();
            if (Util::checkPassword($password, $encryptedPassword)) {
                $data["success"] = TRUE;
                $data["resetPassword"] = $user->getResetPassword();
                unset($data["message"]);
                $user->setLastLoggedIn(new \DateTime("now"));
                $em->persist($user);
                $em->flush();
            }
            $session = new Session();
            $session->set('userId', $user->getId());
            $session->set('email', $email);
            $session->set('userlevel', $user->getUserlevel());
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/logout", name="user_logout", methods={"GET"})
     */
    public function logout(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $base = new BaseController();
        $base->container = $this->container;
        $base->setRequest($request);
        $base->checkCsrf();
        $base->checkLogin();

        $session = new Session();
        $session->set('email','');
        $session->set('userlevel','');

        return new JsonResponse(
            ["success"=>TRUE]
        );
    }

}
