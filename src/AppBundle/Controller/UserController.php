<?php
namespace AppBundle\Controller;

use AppBundle\Form\UserType;
use AppBundle\Services\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\User;

/**
 * Class UserController
 * @package AppBundle\Controller
 * @Rest\Route("/api")
 */
class UserController extends FOSRestController{

    /**
     * @Rest\Get("/users", name="all_users")
     */
    public function getAction()
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        if ($restresult === null) {
            return new View("Booh il n'y a personne :(", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

    /**
     * @Rest\Get("/users/{id}")
     */
    public function idAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if ($singleresult === null) {
            return new View("L'utilisateur n'existe pas :o", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

    /**
     * @Rest\Post("/users", name="new_user")
     */
    public function postAction(Request $request, FileUploader $fileUploader)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, array('csrf_protection' => false));

        $form->submit($request->request->all());
        $user->setPicture($request->files->get('picture'));


        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $file = $user->getPicture();

            $fileName = $fileUploader->upload($file);
            $user->setPicture($fileName);

            $em->persist($user);
            $em->flush();
            return $user;
        } else {
            return $form;
        }
    }

    /**
     * Vote for a user
     * @Rest\Put("/users/{id_current_user}/vote/{id_vote}")
     */
    public function voteAction($id_current_user, $id_vote){
        // find a user and update his score to +1
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneById($id_vote);
        $user->incrementScore();
        $current_user = $em->getRepository(User::class)->findOneById($id_current_user);
        $current_user->setVoted(true);
        $em->flush();
        return ["user_vote"=>$user , "current_user"=>$current_user];
    }

    /**
     * @param Request $request
     *
     * @Rest\Post("/check")
     */
    public function checkAction(Request $request)
    {
        $email = $request->get('email');
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneByEmail($email);
            if ($user === null) {
                return false;
            } else {
                return $user;
            }
        }

}
