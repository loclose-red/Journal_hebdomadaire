<?php

namespace App\Controller;

use App\Entity\Personnalite;
use App\Form\PersonnaliteType;
use App\Repository\PersonnaliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/personnalite")
 */
class PersonnaliteController extends AbstractController
{
    /**
     * @Route("/", name="personnalite_index", methods={"GET"})
     */
    public function index(PersonnaliteRepository $personnaliteRepository): Response
    {
        return $this->render('personnalite/index.html.twig', [
            'personnalites' => $personnaliteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="personnalite_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $personnalite = new Personnalite();
        $form = $this->createForm(PersonnaliteType::class, $personnalite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($personnalite);
            $entityManager->flush();

            return $this->redirectToRoute('personnalite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personnalite/new.html.twig', [
            'personnalite' => $personnalite,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="personnalite_show", methods={"GET"})
     */
    public function show(Personnalite $personnalite): Response
    {
        return $this->render('personnalite/show.html.twig', [
            'personnalite' => $personnalite,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="personnalite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Personnalite $personnalite): Response
    {
        $form = $this->createForm(PersonnaliteType::class, $personnalite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('personnalite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personnalite/edit.html.twig', [
            'personnalite' => $personnalite,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="personnalite_delete", methods={"POST"})
     */
    public function delete(Request $request, Personnalite $personnalite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personnalite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($personnalite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('personnalite_index', [], Response::HTTP_SEE_OTHER);
    }
}
