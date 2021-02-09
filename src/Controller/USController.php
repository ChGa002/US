<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Semestre;
use App\Entity\Module;
use App\Entity\Post;
use App\Repository\SemestreRepository;

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
	 public function repertoires()
	 {
		 $semestreRepository = $this->getDoctrine()->getRepository(Semestre::class);
		 $semestres = $semestreRepository->findAll();
		 return $this->render('us/repertoires.html.twig', ['semestres' => $semestres]);
	 }
	 
	 
	 
	 
	
	 
	 
	/**
	 * @Route("/module/{id}", name="us_postModule")
	 */
	 public function triPostParModule($id)
	 {
		 $posts= $this->getDoctrine()->getRepository(Post::class)->findByModule($id);
		 return $this->render('us/postParModule.html.twig', ['posts' => $posts]);
		 

	 }
		 
}
