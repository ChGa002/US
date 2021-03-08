<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Semestre;
use App\Entity\Module;
use App\Entity\Post;
use App\Repository\SemestreRepository;
use App\Repository\PostRepository;
use App\Repository\ModuleRepository;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Controller\ObjectManagerInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
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
	 *@Route("/us/favoris", name="us_favoris")
	 */
	 public function favoris()
	 {
		 return $this->render('us/favoris.html.twig');
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
	 
	 
	 
	/**
	 * @Route("/{id}/moduleFavori", name="module_enFavori")
	 */
	 public function moduleEnFavori(Module $module,$id): Response
	 {	 
		 $manager=$this->getDoctrine()->getManager();
		 $user = $this->getUser();

		 if ($module->estUnFavori($user)) {

			 $user->removeModulesFavori($module);

			 $manager->persist($user);
			 $manager->flush();

			 return $this->json([ 'message' => 'Favori bien supprimé'], 200);
		 }
	     $user->addModulesFavori($module);
		 $manager->persist($user);
		 $manager->flush();

		 return $this->json(['message' => 'Favori bien ajouté'], 200);

	 }
	 
	 
	/**
	 * @Route("/{id}/semestreFavori", name="semestre_enFavori")
	 */
	 public function semestreEnFavori(Semestre $semestre, $id): Response
	 {
		 $manager=$this->getDoctrine()->getManager();
		 $user = $this->getUser();

		 if ($semestre->estUnFavori($user)) {

			 $user->removeSemestresFavori($semestre);

			 $manager->persist($user);
			 $manager->flush();

			 return $this->json([ 'message' => 'Favori bien supprimé'], 200);
		 }
	     $user->addSemestresFavori($semestre);
		 $manager->persist($user);
		 $manager->flush();

		 return $this->json(['message' => 'Favori bien ajouté'], 200);

	 }
	 

         /**
     * @Route("/us/parametre", name="us_parametre")
     */
    public function param(): Response
    {
        return $this->render('/us/parametre.html.twig');
    }
}

