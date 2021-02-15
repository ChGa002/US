<?php

namespace App\Controller;

use Doctrine\Persistence\ObjectManager;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/us/parametre/changerPseudo", name="us_changePseudo")
     */
    public function changerPseudo(Request $request): Response
    {
            $user = new Utilisateur();

            $form = $this->createFormBuilder($user)
                                  ->add('pseudo', TextType::class,  array( 'attr' => array ( 'placeholder' => 'Pseudo') ) )
                                  ->getForm();

        return $this->render('us/parametre.html.twig', [ 'formPseudo'=>$form->createView()]);
    }

}
