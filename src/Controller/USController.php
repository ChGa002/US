<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class USController extends AbstractController
{
    /**
     * @Route("/us/accueil", name="us_accueil")
     */
    public function accueil(): Response
    {
        return $this->render('us/accueil.html.twig', [
            'controller_name' => 'USController',
        ]);
    }
     /**
     * @Route("/us/parametre", name="us_parametre")
     */
    public function param(): Response
    {

        return $this->render('us/parametre.html.twig', [
            'controller_name' => 'USController',
        ]);
    }
     /**
     * @Route("/us/parametre/changerPseudo", name="changerPseudo")
     */
    public function changerPseudo(): Response
    {
        
    }

}
