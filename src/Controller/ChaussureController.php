<?php

namespace App\Controller;

use App\Entity\Chaussure;
use App\Form\ChaussureType;
use App\Repository\ChaussureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Panier;
use App\Repository\PanierRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;


#[Route('/chaussures')]
class ChaussureController extends AbstractController
{
    #[Route('/', name: 'app_chaussure_index', methods: ['GET'])]
    public function index(ChaussureRepository $chaussureRepository): Response
    {   
        $chaussures = $chaussureRepository->findAll();
        $nbChaussures = count($chaussures);

        return $this->render('chaussure/index.html.twig', [
            'chaussures' => $chaussures,
            'nbChaussures' => $nbChaussures
        ]);
    }

    #[Route('/new', name: 'app_chaussure_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ChaussureRepository $chaussureRepository): Response
    {
        $chaussure = new Chaussure();
        $form = $this->createForm(ChaussureType::class, $chaussure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chaussureRepository->save($chaussure, true);

            return $this->redirectToRoute('app_chaussure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('chaussure/new.html.twig', [
            'chaussure' => $chaussure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_chaussure_show', methods: ['GET'])]
    public function show(Chaussure $chaussure): Response
    {
        return $this->render('chaussure/show.html.twig', [
            'chaussure' => $chaussure,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_chaussure_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chaussure $chaussure, ChaussureRepository $chaussureRepository): Response
    {
        $form = $this->createForm(ChaussureType::class, $chaussure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chaussureRepository->save($chaussure, true);

            return $this->redirectToRoute('app_chaussure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('chaussure/edit.html.twig', [
            'chaussure' => $chaussure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_chaussure_delete', methods: ['POST'])]
    public function delete(Request $request, Chaussure $chaussure, ChaussureRepository $chaussureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chaussure->getId(), $request->request->get('_token'))) {
            $chaussureRepository->remove($chaussure, true);
        }

        return $this->redirectToRoute('app_chaussure_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/ajouter-au-panier', name: 'chaussure_ajouter_au_panier')]
    public function ajouterAuPanier(Chaussure $chaussure, PanierRepository $panierRepository): Response
    {
        // Vérifier si l'utilisateur est authentifié et s'il a le rôle USER
        $this->denyAccessUnlessGranted('ROLE_USER');

        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Vérifier si l'utilisateur a déjà un panier
        $panier = $user->getPanier();
        if (!$panier) {
            // Créer un nouveau panier et l'associer à l'utilisateur
            $panier = new Panier();
            $panier->setUser($user);
        }

        // Ajouter la chaussure au panier
        $panier->addChaussure($chaussure);

        // Enregistrer le panier
        $panierRepository->save($panier, true);

        // Rediriger l'utilisateur vers la page du panier
        // return new RedirectResponse($this->generateUrl('panier_index'));
        return $this->redirectToRoute('app_chaussure_index', [], Response::HTTP_SEE_OTHER);
    }
}
