<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class InscriptionController extends AbstractController
{   
    private  $entityManager;
     public function __construct( EntityManagerInterface $entityManager)
    {
      $this->entityManager=$entityManager;    
    }
    /**
     * @Route("/inscription", name="app_inscription")
     */
    public function index(Request $request, UserPasswordEncoderInterface  $encoder  , SluggerInterface $slugger): Response
    {    
        $user= new User();
        $form = $this->createForm(InscriptionType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user= $form->getData();
            $password = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($password);
            $brochureFile = $form->get('photoUser')->getData();

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
                $user->setphotoUser($newFilename);
          
            }
           $this->entityManager->persist($user);
           $this->entityManager->flush();
          
        }
        return $this->render('inscription/index.html.twig', [
            'form'=>$form->createView()
        ]
        );
    }
}
