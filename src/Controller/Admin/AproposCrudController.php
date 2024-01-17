<?php

namespace App\Controller\Admin;

use App\Entity\Apropos;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AproposCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Apropos::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            TextField::new('titre'),
            TextField::new('description'),
            TextField::new('contact'),
            TextField::new('facebook'),
            EmailField::new('email'),
            // TextField::new('imageFile')->setFormType(VichImageType::class)->onlyWhenCreating(),
            ImageField::new('file')
            ->setUploadDir('public/image') // Specify the directory where images will be uploaded
            ->setBasePath('image') // Specify the base path for displaying images in the list view
            ->setUploadDir('public/image'), // Specify the directory for displaying images in the edit view

            // TextEditorField::new('description'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $em = $this->getDoctrine()->getManager();

        // Récupérez le nombre d'éléments dans la table apropos
        // $aproposCount = $em->getRepository(Apropos::class)->count([]);
        $result=$this->getDoctrine()->getRepository(Apropos::class)->findAll();
        if (empty($result)) {
            return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL,Action::NEW);
        } else {
            return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL, Action::EDIT, Action::DELETE)
             ->disable(Action::NEW);
        }
    }
    
      public function configureCrud(Crud $crud): Crud
    {
        return $crud
        // ->setDefaultSort(['created_at' => 'DESC']);
        ->setPageTitle('index','Parametres')
        ->setPageTitle('edit','Editer les parametres');
        
    }
}
