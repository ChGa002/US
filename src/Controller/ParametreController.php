<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ParametreController extends AbstractController
{
     /**
     * @Route("/us/parametre/parametre", name="us_parametre")
     */
    public function param(): Response
    {
        return $this->render('/parametre/parametre.html.twig');
    }
     /**
     * @Route("/us/parametre/changementPseudo", name="us_changePseudo")
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

            $request->getSession()->getFlashBag()->add('notice', "Votre pseudo a été mis à jour.");
            return $this->redirectToRoute('us_parametre');  
        }
        return $this->render('/parametre/changementPseudo.html.twig', 
        [ 
           'user' => $user,
           'pseudoForm'=>$pseudoForm->createView(),
        ]);
    }
      /**
     * @Route("/us/parametre/changementMotDePasse", name="us_changeMDP")
     */
    public function changerMotDePasse(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $manager): Response
    {
        $user  = $this->getUser();
        $mdpForm = $this->createFormBuilder($user)
        ->add('motDePasse', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Les deux saisies doivent correspondre.',
            /*'mapped' => false,*/
            'options' => ['attr' => ['class' => 'password-field']],
            'required' => true,
            'first_options'  => ['label' => false,'attr' =>['placeholder' => 'Nouveau mot de passe' ]],
            'second_options' =>  ['label' => false,'attr' =>['placeholder' => 'Retaper le mot de passe' ]],
            'constraints' => [
                new NotBlank(['message' => 'Entrer le mot de passe.', ]),
                new Length([
                    'min' => 8,
                    'minMessage' => 'Votre mot de passe doit faire 8 caractères',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                     ])
                    ]
                ])  
        ->getForm();
        $mdpForm->handleRequest($request);

        if ($mdpForm->isSubmitted() && $mdpForm->isValid()) {
            $user->setMotDePasse(
                $passwordEncoder->encodePassword(
                    $user,
                    $mdpForm->get('motDePasse')->getData()
                )
            );
            $manager->persist($user);
            $manager->flush();

            $request->getSession()->getFlashBag()->add('notice', "Votre mot de passe a été mis à jour.");      
            return $this->redirectToRoute('us_parametre');  
            
        }
        return $this->render('/parametre/changementMotDePasse.html.twig', 
        [ 
           'user' => $user,
           'mdpForm'=>$mdpForm->createView(),
        ]);
    }
    /**
     * @Route("/us/parametre/supprimerCompte", name="us_supprimerCompte")
     */
    public function supprimerCompte(Request $request)
    {
        $active = 'delete';
        $user = $this->getUser();
         
        $suppForm = $this->createFormBuilder()
                                ->add('motDePasse', RepeatedType::class, [
                                    'type' => PasswordType::class,
                                    'invalid_message' => 'Les deux saisies doivent correspondre.',
                                    /*'mapped' => false,*/
                                    'options' => ['attr' => ['class' => 'password-field']],
                                    'required' => true,
                                    'first_options'  => ['label' => false,'attr' =>['placeholder' => 'Saisir le mot de passe' ]],
                                    'second_options' =>  ['label' => false,'attr' =>['placeholder' => 'Retaper le mot de passe' ]],
                                    'constraints' => [
                                        new NotBlank(['message' => 'Entrer le mot de passe.', ]),
                                        new Length([
                                            'min' => 8,
                                            'minMessage' => 'Votre mot de passe doit faire 8 caractères',
                                            // max length allowed by Symfony for security reasons
                                            'max' => 4096,
                                            ])
                                            ]
                                        ])  
                                    ->getForm();
         
        if($suppForm->isSubmitted() && $suppForm->isValid())
        {   
            if($suppForm->handleRequest($request)->isValid()){
                $usrRepo = $em->getRepository(User::class);
                $em->remove($user);
                $em->flush();
                 
                $this->get('security.context')->setToken(null);
                $this->get('request')->getSession()->invalidate();  
                $request->getSession()->getFlashBag()->add('compteSupp', "Votre compte a bien été supprimé.");      
                return $this->redirectToRoute('app_login');  
            }
        }
        return $this->render('/parametre/supprimerCompte.html.twig', [
            'suppForm' => $suppForm->createView(),
            'active' => $active
        ]);
    }


}
