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
        
        function randFilms($genre, $nb, $moviesFullRepository, $posterDirectory)
        {
            $films = $moviesFullRepository->findByGenres($genre);
            $min = 0;
            $max = count($films);
            $arrayFilm = [];
            $arrayReturn = [];
            $i = 0;
            while ($i < $nb) {
                $rnd = rand($min, $max);
                if (!in_array($rnd, $arrayFilm)) {
                    array_push($arrayFilm, $rnd);
                    array_push($arrayReturn, $films[$rnd]);
                    $id = $films[$rnd]->getId();
                    if(file_exists($posterDirectory.$id.".jpg")){
                        $arrayReturn[$i]->urlImg = "/assets/img/posters/$id.jpg";
                    } else {
                        $arrayReturn[$i]->urlImg = "/assets/img/posters/default.jpg";
                    }
                } else {
                    $i--;
                }
                $i++;
            }
            return $arrayReturn;
        }
        //dd(randFilms('action', 10, $moviesFullRepository,$posterDirectory));
        $jsFilmFantasy = json_encode(randFilms('fantasy', 10, $moviesFullRepository,$posterDirectory));
        
        //$films2011 = $moviesFullRepository->findBy(["year"=>2011]);
        //dd($filmsByGenre);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'Netlix',
            'filmsGenresAction' => randFilms('action', 10, $moviesFullRepository,$posterDirectory),
            'filmsGenresFantasy' => randFilms('fantasy', 10, $moviesFullRepository,$posterDirectory),
            'filmsGenresHorror' => randFilms('horror', 10, $moviesFullRepository,$posterDirectory),
            'jsFilmFantasy' => $jsFilmFantasy,

        ]);
    }
}
