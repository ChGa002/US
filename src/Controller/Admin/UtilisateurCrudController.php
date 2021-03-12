<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UtilisateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Utilisateur::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
            TextField::new('prenom'),
            EmailField::new('mail'),
            BooleanField::new('valide'),
            ArrayField::new('roles'),
            TextEditorField::new('description')->hideOnIndex(),
            DateTimeField::new('derniereConnexion')->hideOnIndex(),
            TextField::new('motDePasse')->hideOnIndex(),
            TextField::new('emplacementPhoto')->hideOnIndex(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $seeAction = Action::new('seeAccount', 'Redirection', 'fas fa-eye')
        ->setLabel(false)
        ->linkToRoute('us_profil', ['pseudo'=>getPseudo()]);
        return $actions
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action){ return $action->setIcon('fa fa-edit')->setLabel(false); })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action){ return $action->setIcon('fa fa-times-circle')->setLabel(false); })
            ->add(Crud::PAGE_INDEX, $seeAction)
            ;
    }
    
}
