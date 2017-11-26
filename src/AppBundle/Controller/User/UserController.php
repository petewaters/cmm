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
        // $user = $this->getDoctrine()
        //     ->getRepository(User::class)
        //     ->findLatest();

        $user = 'werd';

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
        $user = $this->getDoctrine()->getRepository(User::class)->findBy(array('id' => $id));

        return $this->render('user/form.html.twig', array(
            'user' => $user,
        ));       
    }

    /**
     * Matches /user/update/*
     * 
     * @Route("/user/update/{id}", name="user_update")
     */
    public function update($id)
    {
        
    }
}