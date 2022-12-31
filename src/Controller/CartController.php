<?php

namespace App\Controller;

use App\classe\cart;

use App\Entity\Produits;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{    
    private  $entityManager;
    public function __construct( EntityManagerInterface $entityManager)
   {
     $this->entityManager=$entityManager;    
   }
    /**
     * @Route("/mon-panier", name="app_cart")
     */
    public function index( cart $cart): Response
    { 
     
       
        return $this->render('cart/index.html.twig',
        [
            'cart'=>$cart->getfull()
            
        ]);

    }
     /**
     * @Route("/cart/add/{id}", name="add_cart")
     */
    public function add( cart $cart ,$id): Response

    {   
       $cart->add($id);
     
        return $this->redirectToRoute('app_reservation');
    }
}
