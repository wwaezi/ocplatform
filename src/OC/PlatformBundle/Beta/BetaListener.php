<?php
// src/OC/PlatformBundle/Beta/BetaListener.php

namespace OC\PlatformBundle\Beta;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class BetaListener
{
    // Notre processeur
    protected $betaHTML;

    // La date de fin de la version bêta :
    // - Avant cette date, on affichera un compte à rebours (J-3 par exemple)
    // - Après cette date, on n'affichera plus le « bêta »
    protected $endDate;

    public function __construct(BetaHTMLAdder $betaHTML, $endDate)
    {
        $this->betaHTML = $betaHTML;
        $this->endDate  = new \Datetime($endDate);
    }

    // L'argument de la méthode est un FilterResponseEvent
    public function processBeta(FilterResponseEvent $event)
    {

        // On teste si la requête est bien la requête principale (et non une sous-requête)
        if (!$event->isMasterRequest()) {
            return;
        }

        $dansLeFuture = $this->endDate->diff(new \Datetime())->invert;

        // echo $remainingDays;exit();

        if (!$dansLeFuture) {
            // Si la date est dépassée, on ne fait rien
            return;
        }

        $remainingDays = $this->endDate->diff(new \Datetime())->days + 1;

        // On utilise notre BetaHRML
        $response = $this->betaHTML->addBeta($event->getResponse(), $remainingDays);

        $event->setResponse($response);

        // On stoppe la propagation de l'évènement en cours (ici, kernel.response)
        // $event->stopPropagation();
    }
}