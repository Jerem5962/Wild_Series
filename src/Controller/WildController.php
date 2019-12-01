<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Saison;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * Getting a program with a formatted slug for title
     *
     * @param string $slug The slugger
     * @Route("/wild/show/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null}, name="show")
     * @return Response
     */
    public function show(?string $slug):Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with '.$slug.' title, found in program\'s table.'
            );
        }

        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug'  => $slug,
        ]);
    }

    /**
     * @param string $categoryName
     * @Route("/category/{categoryName}", name="show_category")
     * @return Response
     */
    public function showByCategory(string $categoryName): Response
    {
        $category = $this->getDoctrine()
            ->getManager()
            ->getRepository(Category::class)
            ->findOneBy(
                    ['name' => $categoryName]);

        $categoryId = $category->getId();

        $movies = $this->getDoctrine()
            ->getManager()
            ->getRepository(Program::class)
            ->findBy(['category' => $categoryId],
                    ['id' => 'DESC'],
                    3
                );
        return $this->render('wild/category.html.twig', [
            'movies' => $movies
        ]);
    }

    public function new(): Response
    {
        // traitement d'un formulaire par exemple

        // redirection vers la page 'wild_show', correspondant à l'url wild/show/5
        return $this->redirectToRoute('wild_show', ['page' => 5]);
    }

    /**
     * @param string $slug
     * @return Response
     * @Route("wild/program/{slug<^[a-z0-9-]+$>}", name="program")
     */
    public function showByProgram(?string $slug): Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => $slug]);
        $program_id = $program->getId();
        $season = $this->getDoctrine()
            ->getManager()
            ->getRepository(Saison::class)
            ->findBy(['program' => $program_id]);

        $title = preg_replace(
            '/ /',
            '-', strtolower($slug)
        );

        return $this->render('wild/program.html.twig', [
            'program' => $program,
            'seasons' => $season,
            'slug' => $title
        ]);
    }

    /**
     * @param int $id
     * @return Response
     * @Route("wild/program/{slug<^[a-z0-9-]+$>}/{id}", name="season")
     */
    public function showBySeason(int $id):Response
    {

        $season = $this->getDoctrine()
                        ->getRepository(Saison::class)
                        ->findOneBy(['id' => $id]);
        $episodes = $season->getEpisodes();
        $program = $season->getProgram();

        $title_program = preg_replace(
            '/ /',
            '-', strtolower($program->getTitle())
        );


        return $this->render('wild/season.html.twig', [
            'program' => $program,
            'episodes' => $episodes,
            'season' => $season,
            'title' => $title_program
        ]);
    }

    /**
     * @Route ("/wild/{episode}")
     * @ParamConverter("episode" , class="App\Entity\Episode", options={"id"="episode"})
     * @param Episode $episode
     * @return Response
     */
    public function showEpisode(Episode $episode): Response
    {
        $saison = $episode->getSaison();
        $program = $episode->getProgram();
        $title_program = preg_replace(
            '/ /',
            '-', strtolower($program->getTitle())
        );
        $saison_id = $saison->getId();

        return $this->render('wild/episode.html.twig', [
            "episode" => $episode,
            "saison" => $saison,
            "program" => $program,
            "title" => $title_program,
            "id" => $saison_id
        ]);
    }
}