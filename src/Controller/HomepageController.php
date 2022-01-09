<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\ImageFilename;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use App\Repository\ImageFilenameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(HttpFoundationRequest $request, ContactNotification $contactNotification, ImageFilenameRepository $imageFileNameRepo): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();
            $contactNotification->notify($contact);
            $this->addFlash('success', 'Votre email a bien été envoyé.');
            return $this->redirectToRoute('accueil');
        }

        $getAllUpload = $imageFileNameRepo->findAll();
        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
            'allUpload' => $getAllUpload,
            'form' => $form->createView()
        ]);
    }

    /**
    * @Route("/ImageFilename/{id}", name="accueil_delete", methods="POST")
    */
    public function delete(HttpFoundationRequest $request, ImageFilename $imageFileNameRepo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imageFileNameRepo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($imageFileNameRepo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('accueil', [], Response::HTTP_SEE_OTHER);
    }
    
}
