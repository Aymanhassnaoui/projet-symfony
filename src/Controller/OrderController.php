<?php

namespace App\Controller;

use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class OrderController extends AbstractController
{

  private  $entityManager;
  public function __construct( EntityManagerInterface $entityManager)
 {
   $this->entityManager=$entityManager;    
 }

    #[Route('/order', name: 'app_order')]
    public function index($id): Response
    {    
      $repo=$this->entityManager->getRepository(Reservation::class);
      $reservation  = $repo->findAll($id);      
      

        return $this->render('order/index.html.twig', [
           'reservation'=>$reservation
        ]);
    }
}
