<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(TranslatorInterface $translator, RecipeRepository $recipeRepository): Response
    {
        $count = $recipeRepository->count([]);
        // dd($translator->trans('Welcome'));
        return $this->render('home/index.html.twig',
        [
            'count' => $count
        ]);
    }
}
