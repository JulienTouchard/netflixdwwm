<?php

namespace App\Controller;

use App\Repository\MoviesFullRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/ ', name: 'app_home')]
    public function index(MoviesFullRepository $moviesFullRepository): Response
    {
        $films2011 = $moviesFullRepository->findBy(["year"=>2011]);
        //dd($films2011);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'films2011' => $films2011,
        ]);
    }
}
