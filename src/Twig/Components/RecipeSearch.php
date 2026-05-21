<?php

namespace App\Twig\Components;

use App\Repository\RecipeRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class RecipeSearch
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    public function __construct(
        private RecipeRepository $recipeRepository
    ) {
    }

    public function getRecipes(): array
    {
        if (!$this->query) {
            return [];
        }

        return $this->recipeRepository
            ->createQueryBuilder('r')
            ->where('LOWER(r.title) LIKE LOWER(:query)')
            ->setParameter('query', '%' . $this->query . '%')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}