<?php

namespace AppBundle\Controller\User;

use AppBundle\Entity\User;   
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UserController extends Controller
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
    
        $user = $this->getDoctrine()
                     ->getRepository(User::class)
                     ->findOneBy(array('id' => ($this->get('security.token_storage')->getToken()->getUser())->getId()));

        return $this->render('user/index.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * Matches /user/edit/* 
     * 
     * @Route("/user/edit/{id}", name="user_edit")
     */
    public function edit($id)
    {
        $user = $this->getDoctrine()
                     ->getRepository(User::class)
                     ->findOneBy(array('id' => ($this->get('security.token_storage')->getToken()->getUser())->getId()));

        $form = $this->createForm(UserType::class, $user);

        return $this->render('user/form.html.twig', array(
            'form' => $form->createView(),
            'avatar' => $user->getAvatar(),
        ));       
    }

    /**
     * Matches /user/update/*
     * 
     * @Route("/user/update", name="user_update")
     */
    public function update(Request $request)
    {
        
    }
}