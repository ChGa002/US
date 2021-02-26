<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MotCle;
use App\Entity\Note;
use Doctrine\ORM\EntityManagerInterface;
/**
 * @Route("/us/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="post_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setDatePubli(new \DateTime('now'));
            $post->setCreateur($this->getUser());
            $post->setSignale(false);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('post_show', [
                'id' => $post->getId() ]);
        }

        return $this->render('post/ajoutModif.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
            'action' => 'creer'
        ]);
    }

    /**
     * @Route("/{id}", name="post_show", methods={"GET"})
     */
    public function show(PostRepository $postRepo, NoteRepository $noteRepo, $id): Response
    {

        //$noteMoyenne = $noteRepo->findNoteMoyenne($id);

        $post = $postRepo->findPostOptimise($id);

        $noteMoyenne = $post->noteMoyenne($noteRepo);

        $user = $this->getUser();
        
        if ($post->estNoteParUtilisateur($user))
        {
            $maNote = $noteRepo->findMaNote($post, $user)->getNote();

        } else { $maNote = 0; }


        return $this->render('post/show.html.twig', [
            'post' => $post,
            'noteMoyenne' => $noteMoyenne,
            'maNote' => $maNote
        ]);
    }

    /**
     * @Route("/{id}/edit", name="post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_show', [
                'id' => $post->getId() ]);
        }

        return $this->render('post/ajoutModif.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
            'action' => 'modifier'
        ]);
    }

    /**
     * @Route("/{id}", name="post_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index');
    }
    /**
     * @Route("/{id}/signaler", name="post_signaler", methods={"GET"})
     */
    public function signaler(Post $post, $id): Response
    {
        $post->setSignale(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();
        return $this->json(['message' => 'Post bien signalé'], 200);
    }

    /**
     * @Route("/{id}/favori", name="post_enFavori")
     */
    public function postEnFavori(Post $post, EntityManagerInterface $manager, $id): Response
    {
        $user = $this->getUser();

        if ($post->estUnFavori($user)) {

            $user->removePostsFavori($post);

            $manager->persist($user);
            $manager->flush();

        return $this->json([ 'message' => 'Favori bien supprimé'], 200);
      
        }
        
        $user->addPostsFavori($post);
        $manager->persist($user);
        $manager->flush();

        return $this->json(['message' => 'Favori bien ajouté'], 200);

    }

        /**
     * @Route("/{id}/noter/{noteEtoiles}", name="post_noter")
     */
    public function noterPost(Post $post, $noteEtoiles, EntityManagerInterface $manager, NoteRepository $noteRepo): Response
    {
        $user = $this->getUser();

        if ($post->estNoteParUtilisateur($user)) {

            $note = $noteRepo->findOneBy(
                ['post' => $post,
                'utilisateur' => $user]);
            $note->setNote($noteEtoiles);
            $note->setDate(new \DateTime('now'));

            $manager->persist($note);
            $manager->flush();

        return $this->json([ 'message' => 'Note mise à jour'], 200);
      
        }
        
        $note = new Note();
        $note->setPost($post);
        $note->setUtilisateur($user);
        $note->setDate(new \DateTime('now'));
        $note->setNote($noteEtoiles);

        $manager->persist($note);
        $manager->flush();

        return $this->json(['message' => 'Note créée'], 200);

    }

}
