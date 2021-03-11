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
            TextEditorField::new('description')->hideOnForm(),
            DateTimeField::new('derniereConnexion')->onlyOnDetail(),
            BooleanField::new('valide')->hideOnForm(),
            ArrayField::new('roles')->hideOnForm(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $editAction = Action::new('editAccount', 'Edition', 'fa fa-edit')
        ->linkToRoute('us_moduser');
        $seeAction = Action::new('seeAccount', 'Redirection', 'fa fa-eye')
        ->linkToRoute('us_profil');
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action){ return $action->setIcon('fa fa-times-circle')->setLabel(false); })
            ->add(Crud::PAGE_DETAIL, $editAction)
            ->add(Crud::PAGE_DETAIL, $seeAction)
            ;
    }
    
}
