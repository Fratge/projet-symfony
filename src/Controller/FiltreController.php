<?php

namespace App\Controller;

use App\Entity\Filtre;
use App\Form\FiltreType;
use App\Repository\FiltreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/filtre')]
class FiltreController extends AbstractController
{
    #[Route('/', name: 'app_filtre_index', methods: ['GET'])]
    public function index(FiltreRepository $filtreRepository): Response
    {
        return $this->render('filtre/index.html.twig', [
            'filtres' => $filtreRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_filtre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FiltreRepository $filtreRepository): Response
    {
        $filtre = new Filtre();
        $form = $this->createForm(FiltreType::class, $filtre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filtreRepository->save($filtre, true);

            return $this->redirectToRoute('app_filtre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('filtre/new.html.twig', [
            'filtre' => $filtre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_filtre_show', methods: ['GET'])]
    public function show(Filtre $filtre): Response
    {
        return $this->render('filtre/show.html.twig', [
            'filtre' => $filtre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_filtre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Filtre $filtre, FiltreRepository $filtreRepository): Response
    {
        $form = $this->createForm(FiltreType::class, $filtre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filtreRepository->save($filtre, true);

            return $this->redirectToRoute('app_filtre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('filtre/edit.html.twig', [
            'filtre' => $filtre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_filtre_delete', methods: ['POST'])]
    public function delete(Request $request, Filtre $filtre, FiltreRepository $filtreRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$filtre->getId(), $request->request->get('_token'))) {
            $filtreRepository->remove($filtre, true);
        }

        return $this->redirectToRoute('app_filtre_index', [], Response::HTTP_SEE_OTHER);
    }
}
