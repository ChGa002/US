<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Semestre;
use App\Entity\Module;
use App\Entity\Post;
use App\Repository\SemestreRepository;
use App\Repository\PostRepository;
use App\Repository\ModuleRepository;

class USController extends AbstractController
{
    /**
     * @Route("/accueil", name="us_accueil")
     */
    public function accueil(): Response
    {
        return $this->render('us/accueil.html.twig', [
            'controller_name' => 'USController',
        ]);
    }
	
	
	/**
	 * @Route("/repertoires", name="us_repertoires")
	 */
	 public function repertoires(SemestreRepository $semestreRepository)
	 {
			// On va récupérer au sein de la variable post le contenu du repository après la méthode findAll
		 $semestres = $semestreRepository->findAll();
		 
			// Ici on va afficher la page définie par le fichier repertoires.html.twig en transmettant la variable $semestres
		 return $this->render('us/repertoires.html.twig', ['semestres' => $semestres]);
	 }
	 
	 
	 
	/**
	 * @Route("/module/{id}", name="us_postModule")
	 */
	 public function triPostParModule(Module $module)
	 {	
			// Ici on va afficher la page définie par le fichier postParModule.html.twig en transmettant la variable $posts
		 return $this->render('us/postParModule.html.twig', ['module' => $module]);
		 

	 }
	 
	 
	 

		 
}
