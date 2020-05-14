<?php

namespace App\Controller;
use Cocur\Slugify\Slugify;
use App\Repository\PropertyRepository;
use App\Entity\Property;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{

    private $repository;

    private $em;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/biens", name="property.index")
     */
    public function index() : Response
    {
        return $this->render('property/index.html.twig', ['current_menu' => 'properties']);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"} )
     */
    public function show(Property $property ,string $slug) : Response
    {
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show',[
                'id' => $property -> getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

        return $this->render('property/show.html.twig', [ 
            'property' => $property,
            'current_menu'=>'properties']);
    }
}
