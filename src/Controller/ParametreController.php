<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ParametreController extends AbstractController
{
     /**
     * @Route("/us/parametre", name="us_parametre")
     */
    public function param(): Response
    {

        return $this->render('/us/parametre.html.twig', [
            'controller_name' => 'USController',
        ]);
    }
     /**
     * @Route("/us/parametre/changerPseudo", name="us_changePseudo")
     */
    public function changerPseudo(Request $request, EntityManagerInterface $manager): Response
    {
        $user  = $this->getUser();

        $pseudoForm = $this->createFormBuilder($user)
        ->add('pseudo', TextType::class, ['attr'=>['placeholder'=>'Nouveau Pseudo']])
        ->getForm();
        $pseudoForm->handleRequest($request);

        if ($pseudoForm->isSubmitted() && $pseudoForm->isValid()) {
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('us_parametre');        
        }
        return $this->render('/us/parametre.html.twig', 
        [ 
           'user' => $user,
           'pseudoForm'=>$pseudoForm->createView(),
        ]);
    }

}
