<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Semestre;
use App\Entity\Module;
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
		 $SemestreRepository = $this->getDoctrine()->getRepository(Semestre::class);
		 $semestres = $SemestreRepository->findAll();
		 return $this->render('us/repertoires.html.twig', ['semestres' => $semestres]);
	 }
	 
	 
	 
	 
	
	 
	 
	/**
	 * @Route("/Module/{id}", name="us_postModule")
	 */
	 public function triPostParModule($id)
	 {
		 $module= $this->getDoctrine()->getRepository(Module::class)->find($id);
		 return $this->render('us/Module.html.twig', ['module' => $module,]);
	 }
		 
}
