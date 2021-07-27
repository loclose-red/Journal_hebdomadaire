<?php

namespace App\Controller;

use App\Entity\Journaliste;
use App\Form\JournalisteType;
use App\Repository\JournalisteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/journaliste")
 */
class JournalisteController extends AbstractController
{
    /**
     * @Route("/", name="journaliste_index", methods={"GET"})
     */
    public function index(JournalisteRepository $journalisteRepository): Response
    {
        return $this->render('journaliste/index.html.twig', [
            'journalistes' => $journalisteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="journaliste_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $journaliste = new Journaliste();
        $form = $this->createForm(JournalisteType::class, $journaliste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($journaliste);
            $entityManager->flush();

            return $this->redirectToRoute('journaliste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('journaliste/new.html.twig', [
            'journaliste' => $journaliste,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="journaliste_show", methods={"GET"})
     */
    public function show(Journaliste $journaliste): Response
    {
        return $this->render('journaliste/show.html.twig', [
            'journaliste' => $journaliste,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="journaliste_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Journaliste $journaliste): Response
    {
        $form = $this->createForm(JournalisteType::class, $journaliste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('journaliste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('journaliste/edit.html.twig', [
            'journaliste' => $journaliste,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="journaliste_delete", methods={"POST"})
     */
    public function delete(Request $request, Journaliste $journaliste): Response
    {
        if ($this->isCsrfTokenValid('delete'.$journaliste->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($journaliste);
            $entityManager->flush();
        }

        return $this->redirectToRoute('journaliste_index', [], Response::HTTP_SEE_OTHER);
    }
}
