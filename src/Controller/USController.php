<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Semestre;
use App\Entity\Utilisateur;
use App\Entity\Module;
use App\Entity\Post;
use App\Repository\DateResetRepository;
use App\Repository\SemestreRepository;
use App\Repository\PostRepository;
use App\Repository\ModuleRepository;
use App\Repository\NoteRepository;
use App\Repository\RessourceRepository;
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
    public function accueil(PostRepository $postRepo, NoteRepository $noteRepo): Response
    {
    	$utilisateur = $this->getUser();

    	$posts = $postRepo->findPostsAccueil($utilisateur, $utilisateur->getUtilisateursFavoris(), $utilisateur->getModulesFavoris(), $utilisateur->getSemestresFavoris());

    	$notesPosts = array();
		foreach($posts as $post)
		{	
			$notesPosts[$post->getId()]=$post->noteMoyenne($noteRepo);
		} 

        return $this->render('us/accueil.html.twig', [
            'posts' => $posts,'notesPosts' => $notesPosts
        ]);
    }

	/**
	 *@Route("/us/favoris", name="us_favoris")
	 */
	 public function favoris(PostRepository $postRepo, NoteRepository $noteRepo)
	 {
		 $user=$this->getUser();
		 $posts = $user->getPostsFavoris();
		 $notesPosts = array();
		foreach($posts as $post)
		{	
			$notesPosts[$post->getId()]=$post->noteMoyenne($noteRepo);
		}
		return $this->render('us/favoris.html.twig',['posts' => $posts, 'notesPosts' => $notesPosts]);
	 }
	 
	 
	 


	/**
	 * @Route("/us/repertoires", name="us_repertoires")
	 */
	 public function repertoires(SemestreRepository $semestreRepository)
	 {
			// On va récupérer au sein de la variable post le contenu du repository après la méthode findAll
		 $semestres = $semestreRepository->findAll();
		 
			// Ici on va afficher la page définie par le fichier repertoires.html.twig en transmettant la variable $semestres
		 return $this->render('us/repertoires.html.twig', ['semestres' => $semestres]);
	 }
	 
	 
	/**
	 * @Route("/us/module/{id}", name="us_postModule")
	 */
	 public function triPostParModule(Module $module, PostRepository $postRepo, NoteRepository $noteRepo)
	 {	
		$posts = $postRepo->findByModule($module);
		$notesPosts = array();
		foreach($posts as $post)
		{	
			$notesPosts[$post->getId()]=$post->noteMoyenne($noteRepo);
		}
		
		
			// Ici on va afficher la page définie par le fichier postParModule.html.twig en transmettant la variable $posts
		 return $this->render('us/postParModule.html.twig', ['module' => $module, 'posts' => $posts, 'notesPosts' => $notesPosts]);
		 

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
	 * @Route("/{id}/utilisateurFavori", name="utilisateur_enFavori")
	 */
	 public function utilisateurEnFavori(Utilisateur $utilisateur, $id): Response
	 {
		 $manager=$this->getDoctrine()->getManager();
		 $user = $this->getUser();

		 if ($utilisateur->estUnFavori($user)) {

			 $user->removeUtilisateursFavori($utilisateur);

			 $manager->persist($user);
			 $manager->flush();

			 return $this->json([ 'message' => 'Favori bien supprimé'], 200);
		 }
	     $user->addUtilisateursFavori($utilisateur);
		 $manager->persist($user);
		 $manager->flush();

		 return $this->json(['message' => 'Favori bien ajouté'], 200);

	 }
	 
     /**
     * @Route("/us/parametres", name="us_parametre")
     */
    public function param(): Response
    {
        return $this->render('/us/parametre.html.twig');
    }

    /**
     * @Route("/us/classement", name="us_classement")
     */
    public function classement(UtilisateurRepository $userRepo, NoteRepository $noteRepo, DateResetRepository $dateRepo): Response
    {	

    	$date = ($dateRepo->findAll())[0]->getDate();
    	$moi = $this->getUser();

    	$users = $userRepo->findUtilisateursNotes($date);

    	$classerUsers = array();
  
    	foreach($users as $user) 
    	{
    		
    		$points = pow($user[1],2) * $user[2];

    		$classerUsers[] = array('user'=> $user[0], 'points' => $points, 'moyenne' => $user[1], 'nbPostsNotes' => $user[2]);
    		
    	} 

    	// On trie par points  décroissants
    	array_multisort(array_column($classerUsers, 'points'), SORT_DESC, $classerUsers);

    	// On cherche le rang de l'utilisateur courant
    	$monRang = array_search($moi, array_column($classerUsers, 'user'));
 		

 		if ($monRang === false) {
 			$monRang = 'Non classé';
 			$mesPoints = 0;
 			$maMoyenne = 0;
 			$nbPostsNotes = 0;

		} else {
			$mesPoints = pow($users[$monRang][1],2) * $users[$monRang][2];
			$maMoyenne = $users[$monRang][1];
			$nbPostsNotes = $users[$monRang][2];
			$monRang+=1;
		}

    	$mesPointsTotaux = pow($moi->noteMoyenne($noteRepo),2)*$moi->getPosts()->count();
    	$maMoyenneTotale = $moi->noteMoyenne($noteRepo);
    	

    	// On ne garde que le top 10
    	$classement = array_slice($classerUsers, 0, 10);
   
    	return $this->render('/us/classement.html.twig', [
    			'classement' => $classement, 'mesPoints' => $mesPoints, 'mesPointsTotaux' => $mesPointsTotaux,
    				'monRang' => $monRang, 'maMoyenneTotale' => $maMoyenneTotale, 'maMoyenne' => $maMoyenne, 'nbPostsNotes' => $nbPostsNotes, 'dateReset' => $date]);
    }

     /**
     * @Route("/us/recherche", name="us_recherche")
     */
    public function recherche(Request $request, PostRepository $postRepo, NoteRepository $noteRepo, ModuleRepository $moduleRepo, UtilisateurRepository $utiRepo, SemestreRepository $semestreRepo, RessourceRepository $ressourceRepo): Response
    {
    	$mot = $request->query->get('motRecherche');

    	$posts = $postRepo->findPostsRecherche($mot);

    	$modules = $moduleRepo->findModulesRecherche($mot);
    	$utilisateurs = $utiRepo->findUtilisateursRecherche($mot);

    	$notesPosts = array();
		foreach($posts as $post)
		{	
			$notesPosts[$post->getId()]=$post->noteMoyenne($noteRepo);
		}
		
		$semestres = $semestreRepo->findAll();

		$typesDeFichier = $ressourceRepo->findTypesDeFichier();

        return $this->render('/us/recherche.html.twig', [
       		'mot' => $mot, 'posts' => $posts, 'notesPosts' => $notesPosts, 'modules' => $modules, 'utilisateurs' => $utilisateurs, 'semestres' => $semestres, 
       			'typesDeFichier' => $typesDeFichier
       	]);
    }

    /**
     * @Route("/us/rechercheAvancee", name="us_rechercheAvancee")
     */
    public function rechercheAvancee(Request $request, PostRepository $postRepo, NoteRepository $noteRepo, ModuleRepository $moduleRepo, UtilisateurRepository $utiRepo, SemestreRepository $semestreRepo, RessourceRepository $ressourceRepo): Response
    {

    	$mot = $request->query->get('mot');

		$semestre = $request->query->get('semestre');

		$tdf = $request->query->get('typesDeFichier');

		if ($semestre == '') $semestre = 'S';

    	$date = $request->query->get('date');
    	$evaluation = $request->query->get('evaluation');
    	$titre = $request->query->get('titre');

    	if ($date != null)
    	{
    		if ($evaluation != null)
    		{		
    			if ($titre != null) // tous les 3 filtres selectionnés
    			{
    				$posts = $postRepo->findPostsRechercheAvancee($mot,'p.datePubli',$date,'note',$evaluation, 'p.titre',$titre, $semestre, $tdf);
    			} else { 			// filtres Date et Evaluation

    				$posts = $postRepo->findPostsRechercheAvancee($mot,'p.datePubli',$date,'note',$evaluation, 'note',$evaluation, $semestre, $tdf);
    			} 
    			
    		} else {

    			if ($titre != null) // filtres Date et Titre
    			{
    				$posts = $postRepo->findPostsRechercheAvancee($mot,'p.datePubli',$date,'p.titre',$titre,'p.titre',$titre, $semestre, $tdf);
    			} else {			// que filtre Date

    				$posts = $postRepo->findPostsRechercheAvancee($mot,'p.datePubli',$date,'p.datePubli',$date,'p.datePubli',$date, $semestre, $tdf);
    			}
    		}

    	} elseif ($evaluation != null) {
    				
    			if ($titre != null) // filtres Evaluation et Titre
    			{
    				$posts = $postRepo->findPostsRechercheAvancee($mot,'note',$evaluation,'note',$evaluation, 'p.titre',$titre, $semestre, $tdf);
    			} else { 			// que filtre Evaluation

    				$posts = $postRepo->findPostsRechercheAvancee($mot,'note',$evaluation,'note',$evaluation, 'note',$evaluation, $semestre, $tdf);
    			} 

    	} else {
    		$posts = $postRepo->findPostsRechercheAvancee($mot,'p.titre',$titre,'p.titre',$titre,'p.titre',$titre, $semestre, $tdf);
    	}

    	// Si on ne trouve rien en bd correspondant à la recherche
    	if ($posts == []) $listePosts = [];

    	$modules = $moduleRepo->findModulesRecherche($mot);
    	$utilisateurs = $utiRepo->findUtilisateursRecherche($mot);

    	$notesPosts = array();
		foreach($posts as $ensemble)
		{	
			$post = $ensemble[0];

			$listePosts[] = $post;
			$notesPosts[$post->getId()]=$ensemble['note'];
		}

		
		$semestres = $semestreRepo->findAll();

		$typesDeFichier = $ressourceRepo->findTypesDeFichier();
		
        return $this->render('/us/recherche.html.twig', [
       		'mot' => $mot, 'posts' => $listePosts, 'notesPosts' => $notesPosts, 'modules' => $modules, 'utilisateurs' => $utilisateurs, 'semestres' => $semestres, 
       			'typesDeFichier' => $typesDeFichier
       	]);
    }


}

