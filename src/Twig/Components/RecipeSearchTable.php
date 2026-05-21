<?php

namespace App\Twig\Components;

use App\Repository\RecipeRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class RecipeSearchTable
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    public function __construct(private RecipeRepository $recipeRepository)
    {
    }

    public function getRecipes(): array
    {
        if (strlen($this->query) < 2) {
            return [];
        }

        return $this->recipeRepository->searchByTitle($this->query);
    }

    public function isSearching(): bool
    {
        return strlen($this->query) >= 2;
    }
}