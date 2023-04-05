<?php

namespace App\Controller;

use App\Entity\MoviesFull;
use App\Form\MoviesFullType;
use App\Repository\MoviesFullRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movies/full')]
class MoviesFullController extends AbstractController
{
    #[Route('/', name: 'app_movies_full_index', methods: ['GET'])]
    public function index(MoviesFullRepository $moviesFullRepository): Response
    {
        return $this->render('movies_full/index.html.twig', [
            'movies_fulls' => $moviesFullRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_movies_full_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MoviesFullRepository $moviesFullRepository): Response
    {
        $moviesFull = new MoviesFull();
        $form = $this->createForm(MoviesFullType::class, $moviesFull);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $moviesFullRepository->save($moviesFull, true);

            return $this->redirectToRoute('app_movies_full_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('movies_full/new.html.twig', [
            'movies_full' => $moviesFull,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_movies_full_show', methods: ['GET'])]
    public function show(MoviesFull $moviesFull): Response
    {
        return $this->render('movies_full/show.html.twig', [
            'movies_full' => $moviesFull,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_movies_full_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MoviesFull $moviesFull, MoviesFullRepository $moviesFullRepository): Response
    {
        $form = $this->createForm(MoviesFullType::class, $moviesFull);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $moviesFullRepository->save($moviesFull, true);

            return $this->redirectToRoute('app_movies_full_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('movies_full/edit.html.twig', [
            'movies_full' => $moviesFull,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_movies_full_delete', methods: ['POST'])]
    public function delete(Request $request, MoviesFull $moviesFull, MoviesFullRepository $moviesFullRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$moviesFull->getId(), $request->request->get('_token'))) {
            $moviesFullRepository->remove($moviesFull, true);
        }

        return $this->redirectToRoute('app_movies_full_index', [], Response::HTTP_SEE_OTHER);
    }
}
