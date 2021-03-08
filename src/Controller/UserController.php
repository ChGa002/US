<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Entity\Post;
use App\Entity\Note;
use App\Repository\PostRepository;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class UserController extends AbstractController
{
    /**
     * @Route("/us/profil/{pseudo}", name="us_profil")
     */
    public function afficherProfil(Utilisateur $user, PostRepository $postRepo, $pseudo, NoteRepository $noteRepo): Response
    {
        // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $posts = $postRepo->findBy(array('createur'=> $user),array('datePubli'=>'desc'));
        $noteUtilisateur = $user->noteMoyenne($noteRepo);
        
        $notesPosts = array();

        foreach($posts as $post)
        {
            $notesPosts[$post->getId()] = $post->noteMoyenne($noteRepo);
        }

        dump($notesPosts);

        return $this->render('profil/user.html.twig', [
            'posts' => $posts, 'notes' => 'note', 'user' => $user, 'noteUtilisateur' => $noteUtilisateur, 'notesPosts' => $notesPosts
        ]);

        

    }

     /**
    * @Route("/{pseudo}/favori", name="utilisateur_enFavori")
    */
    public function utilisateurEnFavori(Utilisateur $user, $pseudo): Response
    {
        $manager=$this->getDoctrine()->getManager();
        $userCourant = $this->getUser();

    if ($user->estUnFavori($userCourant)) {
        $userCourant->removeUtilisateursFavori($user);
        $manager->persist($userCourant);
        $manager->flush();
        return $this->json([ 'message' => 'Favori bien supprimé'], 200);
    }

    $userCourant->addUtilisateursFavori($user);
    $manager->persist($userCourant);
    $manager->flush();
    return $this->json(['message' => 'Favori bien ajouté'], 200);
    }
   
    /**
     * @Route("/us/moduser", name="us_moduser")
     */
    public function modifierUser(Request $request, EntityManagerInterface $manager, NoteRepository $noteRepo, PostRepository $postRepo): Response
    {
        $utilisateur = $this->getUser();
        $noteUtilisateur = $utilisateur->noteMoyenne($noteRepo);    
        
        $form = $this->createFormBuilder($utilisateur)
                ->add('description', TextareaType::class, [
                    'attr' => [
                        'placeholder' => "Entrez une description..",
                        "style"=> "resize:none", "rows"=> "3"
                    ]
                ])
                ->add('emplacementPhoto', TextType::class, [
                    'attr' => [
                        'placeholder' => "URL de la photo.."
                    ]
                ])
                ->getForm();

        /*On demande au formulaire d'analyser la dernière requête http */
        $form->handleRequest($request);
       
        if($form->isSubmitted() ){
            //Enregistrer dans la bd
            $manager->persist($utilisateur);
            $manager->flush();
            //Rediriger l'utilisateur vers sa page de profil
            return $this->redirectToRoute('us_profil');
        }

        //Page qui affiche le formulaire
        return $this->render('profil/moduser.html.twig',
            [ 'formUser' => $form->createView(), 'noteUtilisateur' => $noteUtilisateur, 'user' => $utilisateur
            ]);
    }




    /**
     * @Route("/us/profile/{pseudo}/modpost", name="us_modpost")
     */
    public function modifierPost(Utilisateur $user, PostRepository $postRepo, NoteRepository $noteRepo): Response
    {
        // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $posts = $postRepo->findBy(array('createur'=> $user),array('datePubli'=>'desc'));

        $notesPosts = array();

        foreach($posts as $post)
        {
            $notesPosts[$post->getId()] = $post->noteMoyenne($noteRepo);
        }

        return $this->render('profil/modpost.html.twig', [
            'posts' => $posts, 'notesPosts' => $notesPosts, 'user' => $user
        ]);
    }
    
    /**
        * @Route("/us/modpost/delete", name="us_deletePostProfile")
    */ 
    public function deletePost(Request $request, PostRepository $postRepo){

        $em = $this->getDoctrine()->getManager();

        $postsASupprimer = $request->query->get('postASupprimer');
        foreach($postsASupprimer as $postId)
        {
            $post=$postRepo->findOneById($postId);
            $em->remove($post);
        }

        $em->flush();

        return $this->redirectToRoute('us_accueil');


    } 


    
}