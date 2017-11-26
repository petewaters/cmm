<?php

namespace AppBundle\Controller\User;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserController extends Controller
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findLatest();

        return $this->render('user/index.html.twig', array(
            'user' => $user
        ));
    }
}