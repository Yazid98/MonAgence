<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use App\Form\PropertyType;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{

    private $repository;
    private $em;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em){

        $this-> repository= $repository;
        $this->em= $em;

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
     * @Route("/admin_property/admin/{id}", name="admin_property_edit")
     */
    public function edit(Property $property, Request $request) 
    {
        //Après l'édition, on sauvegarde les données en faisant un flush grace à l'EntityManagerInterface
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() )
        {
            $this->em->flush();
            return $this->redirectToRoute('admin_property_index');
        }

        return $this->render('admin_property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ] );
    }

}
