<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Recipe;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecipeController extends AbstractController
{
    #[Route('/recettes/{id}/', name: '.show', requirements: ['id' => Requirement::DIGITS])]
    public function show(Recipe $recipe): Response
    {
        return $this->render('recipe/view.html.twig', [
            'recipe' => $recipe
        ]);
    }
}
