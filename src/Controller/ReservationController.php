<?php

namespace App\Controller;

use App\classe\cart;
use App\Entity\Produits;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Form\ReserverType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class ReservationController extends AbstractController
{
     private  $entityManager;
  public function __construct( EntityManagerInterface $entityManager)
 {
   $this->entityManager=$entityManager;    
 }
    /**
     * @Route("/reservation", name="app_reservation")
     */
    public function index(Request $request , cart $cart , ): Response
    {   
     
      
        $contact= new Reservation();
        $form = $this->createForm(ReservationType::class, $contact,);
        
        $form->handleRequest($request);
        $date = new \DateTime();
        $reference= $date->format(format:'dmy').'-'.uniqid();
        $contact->setReference($reference);
        if ($form->isSubmitted() && $form->isValid()) {
       $date = new \DateTime();
            foreach ( $cart->getfull() as $Produits)

                $contact->setUser($this->getUser());
                $reference= $date->format(format:'dmy').'-'.uniqid();
                
                $contact->setProduit($Produits['produit']);
                $contact->setquantity($Produits['quantity']);
                $contact->setPrix($Produits['produit']->getprix());
                $contact->setTotal($Produits['produit']->getprix()*$Produits['quantity']);
               
                $this->entityManager->persist($contact);
                $this->entityManager->flush();
                return $this->redirectToRoute('app_commande');
      
              
            }
          
  
      
        return $this->render('reservation/reservation.html.twig', [
            'form'=>$form->createView(),
            'cart'=>$cart->getfull(),
             'reference'=> $contact->getReference()
        ]);
    }

    
}
