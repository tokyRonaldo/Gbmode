<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\ContactService;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request,ContactService $contactService): Response
    {
        $contact= new Contact();
        $form=$this->createForm(ContactType::class,$contact );
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $contact=$form->getData();

            $contactService->persistContact($contact);
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
