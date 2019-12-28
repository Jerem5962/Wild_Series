<?php

namespace App\Controller;

use App\Entity\Saison;
use App\Form\SaisonType;
use App\Repository\SaisonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/saison")
 */
class SaisonController extends AbstractController
{
    /**
     * @Route("/", name="saison_index", methods={"GET"})
     */
    public function index(SaisonRepository $saisonRepository): Response
    {
        return $this->render('saison/index.html.twig', [
            'saisons' => $saisonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="saison_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $saison = new Saison();
        $form = $this->createForm(SaisonType::class, $saison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($saison);
            $entityManager->flush();

            return $this->redirectToRoute('saison_index');
        }

        return $this->render('saison/new.html.twig', [
            'saison' => $saison,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="saison_show", methods={"GET"})
     */
    public function show(Saison $saison): Response
    {
        return $this->render('saison/show.html.twig', [
            'saison' => $saison,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="saison_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Saison $saison): Response
    {
        $form = $this->createForm(SaisonType::class, $saison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('saison_index');
        }

        return $this->render('saison/edit.html.twig', [
            'saison' => $saison,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="saison_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Saison $saison): Response
    {
        if ($this->isCsrfTokenValid('delete'.$saison->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($saison);
            $entityManager->flush();
        }

        return $this->redirectToRoute('saison_index');
    }
}
