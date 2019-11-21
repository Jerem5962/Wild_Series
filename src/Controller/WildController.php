<?php
// src/Controller/WildController.php
namespace App\Controller;

use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WildController extends AbstractController
{
    /**
     * @Route("/wild", name = "wild_index")
     */
    public function index() :Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        if (!$programs) {
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }
        return $this->render(
            'wild/index.html.twig', [
            'programs' => $programs,]
        );
    }

    /**
     * @Route("/wild/show/{slug<[a-z0-9-]+>?Aucune séries selectionées, veuillez choisir une série}", name="wild_show")
     * @param $slug
     * @return Response
     */
    public function show($slug): Response
    {
        $slug = ucwords(str_replace("-", " ", $slug)) ;

        return $this->render('wild/show.html.twig', [
            'text' => $slug
        ]);
    }

    public function new(): Response
    {
        // traitement d'un formulaire par exemple

        // redirection vers la page 'wild_show', correspondant à l'url wild/show/5
        return $this->redirectToRoute('wild_show', ['page' => 5]);
    }
}