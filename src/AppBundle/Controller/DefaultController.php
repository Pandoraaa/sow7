<?php

namespace AppBundle\Controller;

use AppBundle\Form\LoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(LoginType::class);

        return $form;
    }

    /**
     * @param Request $request
     * @Rest\Post("/")
     * @return \Symfony\Component\Form\FormInterface
     */
    public function loginAction(Request $request){
        // check if email exists in DB
        // YES : go to vote page
        // NO : go to user creation = return $this->redirectToRoute('new_user');
        $form = $this->createForm(LoginType::class);
        $form->submit($request->request->all());
        return $form;
    }
}
