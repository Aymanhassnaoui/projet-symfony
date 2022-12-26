<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request): Response
    {   
        $contact= new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        return $this->render('contact/contact.html.twig', [
            'form'=>$form->createView()
           
        ]);
    }
}
