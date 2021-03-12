<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    
    // public function configureFields(string $pageName): iterable
    // {
    //     return [
    //         IdField::new('id')->hideOnForm(),
    //         TextField::new('titre'),
    //         TextEditorField::new('description'),
    //         TextEditorField::new('emplacementPhoto')->hideOnIndex(),
    //         BooleanField::new('signale')->hideOnForm(),
    //         TextField::new('createur'),
    //         CollectionField::new('motsCles')->hideOnIndex(),
    //         CollectionField::new('ressources')->hideOnIndex(),
    //         CollectionField::new('modules')->hideOnIndex(),
    //     ];
    // }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action){return $action->setIcon('fa fa-edit')->setLabel(false);})
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action){ return $action->setIcon('fa fa-times-circle')->setLabel(false); });
    }
    
}
