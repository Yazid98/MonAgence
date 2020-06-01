<?php

namespace App\Controller\Admin;

use App\Entity\Option;
use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{
    private $repository;
    private $em;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin_property/admin", name="admin_property_index")
     */
    public function index()
    {
        $properties = $this->repository->findAll();

        return $this->render('admin_property/index.html.twig', compact('properties'));
    }

    /**
     * @Route("/admin_property/admin/create", name="admin_property_new")
     */
    public function new(Request $request)
    {
        //On crée un formulaire
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);

        //Le formulaire gère la requête vers la base de données
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'Créer avec succes');

            return $this->redirectToRoute('admin_property_index');
        }

        return $this->render('admin_property/create.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin_property/admin/{id}", name="admin_property_edit", methods="GET|POST")
     */
    public function edit(Property $property, Request $request)
    {
        
        //Après l'édition, on sauvegarde les données en faisant un flush grace à l'EntityManagerInterface
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Modifié avec succes');

            return $this->redirectToRoute('admin_property_index');
        }

        return $this->render('admin_property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin_property/admin/{id}", name="admin_property_delete", methods="DELETE")
     */
    public function delete(Property $property, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'.$property->getId(), $request->get('_token'))) {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', 'Supprimer avec succès');
        }

        return $this->redirectToRoute('admin_property_index');
    }
}
