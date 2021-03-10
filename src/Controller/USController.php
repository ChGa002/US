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
use App\Repository\NoteRepository;

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


    /**
     * @Route("/us/classement", name="us_classement")
     */
    public function classement(UtilisateurRepository $userRepo, NoteRepository $noteRepo): Response
    {	
    	$date = new \DateTime('2021-02-09');
    	$moi = $this->getUser();

    	$users = $userRepo->findUtilisateursNotes($date);

    	$classerUsers = array();
  
    	foreach($users as $user) 
    	{
    		
    		$points = pow($user[1],2) * $user[2];

    		$classerUsers[] = array('user'=> $user[0], 'points' => $points, 'moyenne' => $user[1]);
    		
    	} 

    	// On trie par points  décroissants
    	array_multisort(array_column($classerUsers, 'points'), SORT_DESC, $classerUsers);

    	// On cherche le rang de l'utilisateur courant
    	$monRang = array_search($moi, array_column($classerUsers, 'user'));
 		

 		if ($monRang == false) {

 			$monRang = 'Non classé';
 			$mesPoints = 0;
 			$maMoyenne = 0;

		} else {
			$mesPoints = pow($users[$monRang][1],2) * $users[$monRang][2];
			$maMoyenne = $users[$monRang][1];
			$monRang+=1;
		}

    	$mesPointsTotaux = pow($moi->noteMoyenne($noteRepo),2)*$moi->getPosts()->count();
    	$maMoyenneTotale = $moi->noteMoyenne($noteRepo);
    	

    	// On ne garde que le top 10
    	$classement = array_slice($classerUsers, 0, 10);

    	return $this->render('/us/classement.html.twig', [
    			'classement' => $classement, 'mesPoints' => $mesPoints, 'mesPointsTotaux' => $mesPointsTotaux,
    				'monRang' => $monRang, 'maMoyenneTotale' => $maMoyenneTotale, 'maMoyenne' => $maMoyenne, 'dateReset' => $date]);
    }
}

