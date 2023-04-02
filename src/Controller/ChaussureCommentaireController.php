<?php

namespace App\Controller;

use App\Entity\Chaussure;
use App\Form\ChaussureType;
use App\Repository\ChaussureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Commentaire;
use App\Form\CommentaireType;

class ChaussureCommentaireController extends AbstractController
{
    /**
    * @Route("/{id}/commentaire", name="app_chaussure_commentaire", methods={"GET", "POST"})
    */
    public function ajouterCommentaire(Request $request, $id): Response
    {
        $chaussure = $this->getDoctrine()->getRepository(Chaussure::class)->find($id);

        if (!$chaussure) {
            throw $this->createNotFoundException('La chaussure n\'existe pas');
        }

        $commentaire = new Commentaire();
        $commentaire->setChaussure($chaussure);

        $form = $this->createForm(CommentaireType::class, $commentaire);
        // var_dump($form);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire = $form->getData();

            // Récupérer l'utilisateur actuel et le définir comme l'utilisateur du commentaire
            $utilisateur = $this->getUser();
            $commentaire->setUser($utilisateur);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();

            $this->addFlash('success', 'Votre commentaire a été ajouté');

            return $this->redirectToRoute('app_chaussure_show', ['id' => $id]);
        }

        return $this->render('chaussure/ajouter.html.twig', [
            'form' => $form->createView(),
            'chaussure' => $chaussure,
        ]);
        
        
    }
}
