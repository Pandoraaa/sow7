<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
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

//    /**
//     * super delete button to empty user table!
//     * @Route("/delete", name="dangeeer")
//     */
//    public function dangerAction(){
//        $em = $this->getDoctrine()->getManager();
//        $em->getRepository(User::class)->remove()
//
//
//    }

}
