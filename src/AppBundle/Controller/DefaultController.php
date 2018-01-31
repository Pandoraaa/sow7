<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class DefaultController
 * @package AppBundle\Controller
 *
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
// TODO recup avec tableau desc score
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findBy(array(), array('score' => 'desc'));

        return $this->render('default/index.html.twig', array(
        'users' => $users
    ));
    }




}
