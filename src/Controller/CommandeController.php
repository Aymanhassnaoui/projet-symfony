<?php

namespace App\Controller;

use App\classe\cart;
use App\Entity\Reservation;
use App\Form\CommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index( cart $cart , Request $request): Response
    {
        $form = $this->createForm(CommandeType::class, null ,[
            'user' => $this->getUser(),
          
        ]);

        $form->handleRequest($request);
       

        return $this->render('commande/index.html.twig', [
            'form'=>$form->createView(),
            'cart'=>$cart->getfull(),
                   ]);
    }



}
