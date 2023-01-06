<?php

namespace App\Controller;

use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesreservationController extends AbstractController
{
    private  $entityManager;
    public function __construct( EntityManagerInterface $entityManager)
   {
     $this->entityManager=$entityManager;    
   }

    #[Route('/mesreservation', name: 'app_mesreservation')]
    public function index(): Response
    {   
        $reservation= $this->entityManager->getRepository(Reservation::class)->findAll(); 
        return $this->render('mesreservation/index.html.twig', [
            'reservation'=> $reservation
           
            
          ]);
    }
}
