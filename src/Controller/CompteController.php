<?php

namespace App\Controller;


use App\Entity\Produits;
use App\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CompteController extends AbstractController
{   
    private  $entityManager;
    public function __construct( EntityManagerInterface $entityManager)
   {
     $this->entityManager=$entityManager;    
   }
    /**
     * @Route("/compte", name="compte")
     */
    public function index(): Response
    {
        return $this->render('compte/index.html.twig');


    
    }



     /**
     * @Route("/anonce", name="anonce ")
     */
    public function anonce(Request $request , SluggerInterface $slugger): Response
    {
        $produit= new Produits();
       
        $form = $this->createForm(ProduitType::class  , $produit   );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
         $produit->setUser($this->getUser());
            $produit= $form->getData();

           $this->entityManager->persist($produit);
           $this->entityManager->flush(); 

          $brochureFile = $form->get('photo')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_EXTENSION);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $produit->setphoto($newFilename);
            }
           
        
        }
        return $this->render('compte/anonce.html.twig', [
            'formcompte'=>$form->createView()
          
        ]);
       
    }
}
