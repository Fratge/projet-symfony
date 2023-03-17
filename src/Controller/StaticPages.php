<?php
namespace App\Controller;
 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Chaussure;
use App\Repository\CastleRepository;

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

}