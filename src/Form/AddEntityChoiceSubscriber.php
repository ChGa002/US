<?php

namespace AppBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class AddEntityChoiceSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * The name of the entity
     *
     * @var string
     */
    protected $entityName;

    public function __construct(EntityManager $em, string $entityName)
    {
        $this->em = $em;
        $this->entityName = $entityName;
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SUBMIT => 'preSubmit',
        ];
    }

    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();

        if (!is_array($data) && !($data instanceof \Traversable && $data instanceof \ArrayAccess)) {
            $data = [];
        }

        // loop through all values
        $repository = $this->em->getRepository($this->entityName);
        $choices = array_map('strval', $repository->findAll());
        $className = $repository->getClassName();
        $newChoices = [];
        foreach($data as $key => $choice) {
            // if it's numeric we consider it the primary key of an existing choice
            if(is_numeric($choice) || in_array($choice, $choices)) {
                continue;
            }
            $entity = new $className($choice);
            $newChoices[] = $entity;
            $this->em->persist($entity);
        }
        $this->em->flush();

        // now we need to replace the text values with their new primary key
        // otherwise, the newly added choice won't be marked as selected
        foreach($newChoices as $newChoice) {
            $key = array_search($newChoice->__toString(), $data);
            $data[$key] = $newChoice->getId();
        }

        $event->setData($data);
    }
}