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

class UserController extends FOSRestController{

    /**
     * @Rest\Get("/user")
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
     * @Rest\Get("/user/{id}")
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
     * @Rest\Post("/user")
     */
    public function postAction(Request $request, FileUploader $fileUploader)
    {
        /*$data = new User;
        $name = $request->get('name');
        $firstName = $request->get('first_name');
        $email = $request->get('email');
        $picture = $request->get('picture');

        if(empty($name) || empty($firstName) || empty($email) || empty($picture))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data->setName($name);
        $data->setFirstName($firstName);
        $data->setEmail($email);
        $data->setPicture($picture);

        $file = $user->getPicture()->getName();
        $fileName = $fileUploader->upload($file);
        $user->getPicture()->setName($fileName);

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        return new View("User Added Successfully", Response::HTTP_OK);
    }*/
        $user = new User();
        $form = $this->createForm(UserType::class, $user, array('csrf_protection' => false));

        $form->submit($request->request->all());


        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            /*$file = $user->getPicture();
            $fileName = $fileUploader->upload($file);
            $user->setPicture($fileName);*/

            $em->persist($user);
            $em->flush();
            return $user;
        } else {
            return $form;
        }
    }

/*  /**
     * @Rest\Post("/user/{id}/vote")
     */
    /*public function voteAction($id){
        // find a user and update his score to +1
        $vote = $this->getDoctrine()->getRepository(User::class)->findOneById($id)
    }*/
}