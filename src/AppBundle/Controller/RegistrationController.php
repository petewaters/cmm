<?php

// src/AppBundle/Controller/RegistrationController.php
namespace AppBundle\Controller;

use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

// Events
use AppBundle\EventsBundle\Event\UserRegistered;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="user_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder = null)
    {
        // Build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // Handle form submit
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Bcrypt the crap out of that password
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // TODO: Should really farm this out to an event

            // $file stores the uploaded image
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $user->getAvatar();
            
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('avatars_dir'),
                $fileName
            );

            // Update the avatar property to store the image file name
            // instead of its contents
            $user->setAvatar($fileName);

            // Dispatch an event to send welcome email
            $event = new UserRegistered('UserRegistered', $user);
            $this->get('event_dispatcher')->dispatch('app.event.user_registered', $event);

            // Save the user
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user');
        }

        return $this->render(
            'auth/register.html.twig',
            array('form' => $form->createView())
        );
    }
}