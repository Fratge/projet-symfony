<?php
namespace App\Controller;
 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Chaussure;
use App\Repository\ChaussureRepository;
use App\Repository\PanierRepository;


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
    public function back_office(ChaussureRepository $chaussureRepository, PanierRepository $panierRepository): Response
    {
        $titlePage = 'Back-Office';

        return $this->render('back_office.html.twig', [
            'titlePage' => $titlePage,
            'chaussures' => $chaussureRepository->findAll(),
            'paniers' => $panierRepository->findAll(),
        ]);
    }


}