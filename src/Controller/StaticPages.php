<?php
namespace App\Controller;
 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Chaussure;
use App\Repository\ChaussureRepository;
use App\Repository\PanierRepository;
use App\Repository\CommentaireRepository;
use App\Repository\FiltreRepository;


class StaticPages extends AbstractController
{
    /**
    * @Route("/", name="home")
    */
    public function home(): Response
    {
        $titlePage = 'Accueil';
 
        return $this->render('home.html.twig', [
            'titlePage' => $titlePage
        ]);
    }

    /**
    * @Route("/contact", name="contact")
    */
    public function contact(): Response
    {
        $titlePage = 'Contact';
 
        return $this->render('contact.html.twig', [
            'titlePage' => $titlePage
        ]);
    }

    /**
     * @Route("/back-office", name="back_office")
     */
    public function back_office(
        ChaussureRepository $chaussureRepository, 
        PanierRepository $panierRepository, 
        FiltreRepository $filtreRepository,
        CommentaireRepository $commentaireRepository): Response
    {
        $titlePage = 'Back-Office';
        $commentaires = $commentaireRepository->findBy([], ['id' => 'DESC'], null, null, ['utilisateur']);
        
        return $this->render('back_office.html.twig', [
            'titlePage' => $titlePage,
            'chaussures' => $chaussureRepository->findAll(),
            'paniers' => $panierRepository->findAll(),
            'commentaires' => $commentaireRepository->findAll(),
            'filtres' => $filtreRepository->findAll(),
        ]);
    }


}