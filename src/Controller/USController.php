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
    public function changerPseudo(Request $request, ObjectManager $manager): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(switchPseudoForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

           $userExistant = $users->findOneByPseudo($user->getPseudo());
            if($userExistant == null || $userExistant->getValide()==true)
            {
                throw $this->createNotFoundException('Vous ne pouvez pas modifier votre pseudo.');
                return $this->render('us/parametre.html.twig', [
                    'changerPseudoForm' => $form->createView(),
                ]);
            }
            $userExistant->setPseudo($user->getPseudo());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userExistant);
            $entityManager->flush();

        
        }
        return $this->render('us/parametre.html.twig', [
            'user' => $user,
             'changerPseudoForm' => $form->createView()
             ]);
    }
}