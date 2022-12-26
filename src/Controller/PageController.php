<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Produits;
use App\Entity\User;
use Doctrine\ORM\Mapping\Id;

class PageController extends AbstractController
{
  private  $entityManager;
  public function __construct( EntityManagerInterface $entityManager)
 {
   $this->entityManager=$entityManager;    
 }
    /**
     * @Route("/", name="app_page")
     */
    public function index(): Response
    {    
        
      $produits=$this->entityManager->getRepository(Produits::class)->findAll();

    
        return $this->render('page/index.html.twig',[
          'produits'=> $produits
         
          
        ]
          );
    }
     /**
     * @Route("/about", name="app")
     */
    public function about(): Response
    {
        return $this->render('page/about.html.twig', 
          );
    }


     /**
     * @Route("/show/{id}", name="ap")
     */
    public function show($id): Response
    {

      $repo=$this->entityManager->getRepository(Produits::class);
     $produits = $repo->find($id);
     

     


    
     
     
    
    

        return $this->render('page/show.html.twig', 
    [
      "produits" => $produits,
     
               
    ]
          );
    }
}
