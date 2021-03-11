<?php

namespace App\Controller\Admin;

use App\Entity\Semestre;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SemestreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Semestre::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action){return $action->setIcon('fa fa-edit')->setLabel(false);})
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action){ return $action->setIcon('fa fa-times-circle')->setLabel(false); });
    }
}
