<?php

namespace App\Form;

use App\Entity\Ressource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class RessourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('nom', TextType::class, [ 'attr' => ['placeholder' => 'Nom du fichier...'] ])
            ->add('typeDeFichier', ChoiceType::class, 
                [ 'choices' => ['Document (.docx, .odt, diaporama...)' => 'document',
                                'Code (html, css, sql...)' => 'code',
                                'Exécutable'=> 'exécutable', 
                                'Image' => 'image', 
                                'Vidéo' => 'vidéo', 
                                'Audio' => 'audio', 
                                'Site web' => 'site web',
                                'Compressé' => 'compressé',
                                'Autre' => 'autre'
            ] ] )
            ->add('emplacement', UrlType::class, [ 'label' => 'Lien ressource', 'attr' => ['placeholder' => 'Lien vers la ressource...'] ]);         
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ressource::class,
        ]);
    }
}
