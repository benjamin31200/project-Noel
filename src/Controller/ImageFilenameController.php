<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ImageFilename;
use App\Form\ImageFilenameType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageFilenameController extends AbstractController
{
    /**
     * @Route("/Upload", name="UploadFile")
     */
    public function new(HttpFoundationRequest $request, SluggerInterface $slugger)
    {
        $imageFilename = new ImageFilename();
        $formUpload = $this->createForm(ImageFilenameType::class, $imageFilename);
        $formUpload->handleRequest($request);

        if ($formUpload->isSubmitted() && $formUpload->isValid()) {
            $imageUpload = $formUpload->get('ImageFilename')->getData();

            if ($imageUpload) {
                $originalFilename = pathinfo($imageUpload->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageUpload->guessExtension();

                try {
                    $imageUpload->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                }

                $imageFilename->setImageFilename($newFilename);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($imageFilename);
            $entityManager->flush();
            return $this->redirectToRoute('accueil');
        }

        return $this->renderForm('imageFilename/contact.html.twig', [
            'formUpload' => $formUpload
        ]);
    }
}
