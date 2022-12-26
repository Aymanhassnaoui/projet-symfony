<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Produits;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class ProduitsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produits::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
           
            TextField::new('type'),
         
            ImageField::new('photo')->setUploadDir('public'),
            MoneyField::new('prix')->setCurrency('EUR'),
            TextField::new('capacite'),
            TextField::new('couchage'),
            DateField::new('ariver'),
            DateField::new ('depart'),
            AssociationField::new('category'),
            
           
        ];
    }
    
}
