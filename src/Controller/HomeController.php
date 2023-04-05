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
        $posterDirectory = str_replace("\\","/",$this->getParameter('assets'))."/img/posters/";
        
        function randFilms($genre, $nb, $moviesFullRepository,$posterDirectory)
        {
            $films = $moviesFullRepository->findByGenres($genre);
            $min = 0;
            $max = count($films);
            $arrayFilm = [];
            $arrayReturn = [];
            $i = 0;
            while ($i < $nb) {
                if (!in_array(rand($min, $max), $arrayFilm)) {
                    array_push($arrayFilm, rand($min, $max));

                    array_push($arrayReturn, $films[rand($min, $max)]);
                    //dd($arrayReturn[count($arrayReturn)-1]->id);
                    $id = $films[rand($min, $max)]->getId();
                   
                    if(file_exists($posterDirectory.$id.".jpg")){
                        //$arrayReturn[$i]
                    } else {
                        
                    }
                } else {
                    $i--;
                }
                $i++;
            }
            return $arrayReturn;
        }
        
        randFilms('action', 10, $moviesFullRepository,$posterDirectory);
        
        
        //$films2011 = $moviesFullRepository->findBy(["year"=>2011]);
        //dd($filmsByGenre);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'filmsGenresAction' => randFilms('action', 10, $moviesFullRepository,$posterDirectory),
        ]);
    }
}
