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

    /**
    * @Route("/chaussures", name="chaussures")
    */
    public function chaussures(): Response
    {
        // Récupère le dépôt lié à la classe Castle
        $repo = $this->getDoctrine()
            ->getRepository(Chaussure::class);
    
        // Exécute une requête SELECT
        $chaussures = $repo->findAll();
        $titlePage = 'test';
    
        // Utilisation du résultat
        return $this->render('chaussures.html.twig', [
            'chaussures' => $chaussures,
            'titlePage' => $titlePage,
        ]);
    }

    /**
     * @Route("/chaussure/{id}", name="chaussure_readone")
     * @param int $id
     * @return Response
    */
    public function chaussure(int $id): Response
    {   
        $titlePage = 'test';

        $repo = $this->getDoctrine()
            ->getRepository(Chaussure::class);
    
        $chaussures = $repo->findAll();
        $chaussure  = $repo->find($id);
    
        // si le château recherché n'existe pas, redirection vers la route "chateaux"
        if (!$chaussure) {
            return $this->redirectToRoute('chaussures');
        }
    
        return $this->render('chaussure.html.twig', [
            'chaussures' => $chaussures,
            'chaussure' => $chaussure
        ]);
    }
}