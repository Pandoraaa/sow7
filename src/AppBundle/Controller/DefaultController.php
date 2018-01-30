<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\LoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Rest\Post("/")
     */
    public function indexAction(Request $request)
    {
        // Formulaire non lié à une entité pour check si email existe
        $form = $this->createFormBuilder(null, ['attr' => ['id' => 'check_email']])
            ->add('email', EmailType::class)
            ->add('submit', SubmitType::class)
            ->getForm();

        // Hydratation du form
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $email = $form->getData()['email'];
            $em = $this->getDoctrine()->getManager();
            $checkLogin = $em->getRepository(User::class)->findOneByEmail($email);
            if ($checkLogin === null) {
                return $this->redirectToRoute('new_user');
            } else {
                return $this->redirectToRoute('all_users');
            }
        }
        return $form;
    }

    // TODO mix entre les 2 fonctions pour checker email dans un form qui lance la requête...
//    /**
//     * @param Request $request
//     * @Rest\Post("/")
//     * @return \Symfony\Component\Form\FormInterface
//     */
//    public function login1Action(Request $request){
//        // check if email exists in DB
//        // YES : go to vote page
//        // NO : go to user creation = return $this->redirectToRoute('new_user');
//        $form = $this->createForm(LoginType::class); // TODO lier vers requête
//        $form->submit($request->request->all());
//        return $form;
//    }
//    /**
//     * @Rest\Get("/")
//     */
//    public function loginAction($email){
//        $checkLogin = $this->getDoctrine()->getRepository('AppBundle:User')->findOneByEmail($email);
//        if ($checkLogin === null) {
//            return $this->redirectToRoute('new_user');
//        }
//        return $this->redirectToRoute('all_users')
//    }



}
