<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class DefaultController
 * @package AppBundle\Controller
 *
 */
class DefaultController extends Controller
{
    /**
     *
     * @Route("/", name="home")
     */
    public function indexAction()
    {
// TODO recup avec tableau desc score
        $scores = $this->getDoctrine()->getRepository('AppBundle:User')->findBy(array(), array('score' => 'desc'));

        return $this->render('default/index.html.twig', array(
        'scores' => $scores
    ));
    }




}
