<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Gedmo\Translatable\Query\TreeWalker\TranslationWalker;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<Recipe>
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Recipe::class);
    }

    public function paginateRecipes(int $page, ?int $userId): PaginationInterface {

    $builder = $this->createQueryBuilder('r')->leftJoin('r.category','c')->select('r','c');
    if($userId){
        $builder = $builder->andWhere('r.user = :userId')
                ->setParameter('userId', $userId);
    }
    return $this->paginator->paginate(
        $builder->getQuery()->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            TranslationWalker::class
        ),
        $page,
        20,
        [
            'distinct' => true,
            'sortFieldAllowList' => ["r.id" , "r.title","c.name"]
        ]

    );
    }

    /**
     * Return recipe with duration lower than parameter
     *
     * @param integer $duration
     * @return Recipe[]
     */
    public function findWithDurationLowerThan(int $duration): array {
        return $this->createQueryBuilder('r')
            ->where('r.duration < :duration')
            ->orderBy('r.duration', 'ASC')
            ->setMaxResults(10)
            ->setParameter('duration', $duration)
            ->getQuery()
            ->getResult();
    }

    public function findTotalDuration(): int{
        return $this->createQueryBuilder('r')
                    ->select("SUM(r.duration) as total")
                    ->getQuery()
                    ->getSingleScalarResult();
    }
    public function searchByTitle(string $query): array
    {
        return $this->createQueryBuilder('r')
            ->leftJoin('r.category', 'c')
            ->select('r', 'c')
            ->where('r.title LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->orderBy('r.title', 'ASC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult();
    }

    // public function searchByTitle(string $query): array
    // {
    //     return $this->createQueryBuilder('r')
    //         ->where('r.title LIKE :query')
    //         ->setParameter('query', '%' . $query . '%')
    //         ->orderBy('r.title', 'ASC')
    //         ->setMaxResults(8)
    //         ->getQuery()
    //         ->getResult();
    // }
//    /**
//     * @return Recipe[] Returns an array of Recipe objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Recipe
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
