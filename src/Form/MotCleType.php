<?php

namespace App\Form;

use App\Entity\MotCle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Form\EventListener\AddEntityChoiceSubscriber;

class MotCleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $subscriber = new AddEntityChoiceSubscriber($options['em'], $options['class']);
        $builder->addEventSubscriber($subscriber);
    }

     /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return EntityType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tag';
    }
    /*
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MotCle::class,
        ]);
    }
    */
}
