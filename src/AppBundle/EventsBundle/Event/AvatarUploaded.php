<?php
namespace AppBundle\EventsBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class AvatarUploaded extends Event
{
    protected $name;
    protected $user;

    public function __construct($name, $user)
    {
        $this->name = $name;
        $this->user = $user;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUser()
    {
        return $this->user;
    }
}