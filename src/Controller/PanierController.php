<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Form\PanierType;
use App\Repository\PanierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Chaussure;


#[Route('/panier')]
class PanierController extends AbstractController
{
    #[Route('/', name: 'app_panier_index', methods: ['GET'])]
    public function index(PanierRepository $panierRepository): Response
    {
        return $this->render('panier/index.html.twig', [
            'paniers' => $panierRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_panier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PanierRepository $panierRepository): Response
    {
        $panier = new Panier();
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $panierRepository->save($panier, true);

            return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('panier/new.html.twig', [
            'panier' => $panier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_panier_show', methods: ['GET'])]
    public function show(Panier $panier): Response
    {   
        // Vérifie si l'utilisateur est connecté
        $user = $this->getUser();
        if (!$user) {
            // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
            return $this->redirectToRoute('app_login');
        }

        // Vérifie si l'utilisateur connecté correspond à l'utilisateur du panier ou si l'utilisateur est un administrateur
        if ($panier->getUser() !== $user && !$this->isGranted('ROLE_ADMIN')) {
            // Redirige vers une page d'erreur si l'utilisateur n'a pas accès à ce panier
            throw $this->createAccessDeniedException('Vous n\'êtes pas autorisé à accéder à ce panier.');
        }
        $panierChaussures = $panier->getChaussure();

        return $this->render('panier/show.html.twig', [
            'panier' => $panier,
            'panierChaussures' => $panierChaussures,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_panier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Panier $panier, PanierRepository $panierRepository): Response
    {
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $panierRepository->save($panier, true);

            return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('panier/edit.html.twig', [
            'panier' => $panier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_panier_delete', methods: ['POST'])]
    public function delete(Request $request, Panier $panier, PanierRepository $panierRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$panier->getId(), $request->request->get('_token'))) {
            $panierRepository->remove($panier, true);
        }

        return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/delete/{chaussureId}', name: 'app_panier_delete_item', methods: ['POST'])]
    public function deleteItem(Request $request, Panier $panier, $chaussureId, PanierRepository $panierRepository): Response
    {
    $chaussure = $this->getDoctrine()
        ->getRepository(Chaussure::class)
        ->find($chaussureId);
    if (!$chaussure) {
        throw $this->createNotFoundException('Chaussure not found');
    }
   
    $panier->removeChaussure($chaussure);
   
    $panierRepository->save($panier, true);
   
    return $this->redirectToRoute('app_panier_show', ['id' => $panier->getId()], Response::HTTP_SEE_OTHER);
    }
}
