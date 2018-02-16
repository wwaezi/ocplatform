<?php
// src/OC/PlatformBundle/Event/MessagePostEvent.php

namespace OC\PlatformBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use OC\UserBundle\Entity\User;

class MessagePostEvent extends Event
{

	protected $message;
	protected $user;

	public function __construct($message, User $user)
	{
		$this->message = $message;
		$this->user    = $user;
	}

	// Le listener doit avoir accès au message
	public function getMessage()
	{
		return $this->message;
	}

	// Le listener doit pouvoir modifier le message
	public function setMessage($message)
	{
		return $this->message = $message;
	}

	// Le listener doit avoir accès à l'utilisateur
	public function getUser()
	{
		return $this->user;
	}

	// Pas de setUser, les listeners ne peuvent pas modifier l'auteur du message !

}