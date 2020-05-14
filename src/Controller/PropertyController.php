<?php

namespace App\Controller;
use App\Entity\Property;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @Route("/biens", name="property.index")
     */
    public function index() : Response
    {
    $property = new Property();
    $property ->setTitle('Mon premier bien')
              ->setDescription('')  
    ;

        return $this->render('property/index.html.twig', ['current_menu' => 'properties']);
    }
}
