<?php
// src/OC/PlatformBundle/Bigbrother/MessageNotificator.php

namespace OC\PlatformBundle\Bigbrother;

use OC\UserBundle\Entity\User;

class MessageNotificator
{
    protected $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    // Méthode pour notifier par e-mail un administrateur
    public function notifyByEmail($message, User $user)
    {

        $message = \Swift_Message::newInstance()
            ->setSubject("Nouveau message d'un utilisateur surveillé")
            ->setFrom($user->getEmail())
            ->setTo('maiwalw@gmail.com')
            ->setBody("L'utilisateur surveillé '".$user->getUsername()."' a posté le message suivant : '".$message."'")
        ;

        $this->mailer->send($message);
    }
}
