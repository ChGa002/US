<?php

namespace App\Form;

use App\Repository\ModuleRepository;
use App\Entity\Post;
use App\Entity\Module;
use App\Entity\MotCle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\ChoiceList\ArrayChoiceList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;
use App\Form\RessourceType;
use App\Form\MotCleType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class)
            ->add('description', TextareaType::class, ['attr'=> ['style'=>'resize:none', 'rows'=>'2']])
            ->add('emplacementPhoto', UrlType::class)
            ->add("motsCles", MotCleType::class, [
                'required' => true,
                'class' => 'App\Entity\MotCle',
                'multiple' => true,
                'attr' => ['class' => 'js-select2',],
                ])
            ->add('modules', EntityType::class, array('class' => Module::class,
                'choice_label' => function(Module $module)
                {return $module->getSigle() ;}, 
                'choice_attr' => function(Module $module)
                {return array($module->getSigle() => $module->getNom()) ;},
                'expanded' => true,
                'multiple' => true
                ))
             ->add('ressources', CollectionType::class, [
                        'entry_type' => RessourceType::class,
                        'entry_options' => ['label' => false],
                        'allow_add' => true,
                        'allow_delete' => true,
                        'by_reference' => false
                ])
            ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
