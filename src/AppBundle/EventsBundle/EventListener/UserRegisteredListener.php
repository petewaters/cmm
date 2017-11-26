<?php
// src/AppBundle/EventBundle/EventListener/PageViewedListener.php
namespace AppBundle\EventsBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use AppBundle\EventsBundle\Event\UserRegistered;

class UserRegisteredListener implements EventSubscriberInterface
{
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'app.event.user_registered' => 'handler',
        );
    }

    public function handler(UserRegistered $event)
    {
        // Send the newly registered user a welcome email
        $message = (new \Swift_Message('Hello from Symfony'))
        ->setFrom('send@example.com')
        ->setTo(($event->getUser())->getEmail())
        ->setBody("Welcome " . ($event->getUser())->getFirstname());

        $this->mailer->send($message);
    }
}