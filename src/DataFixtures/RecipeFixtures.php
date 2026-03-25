<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Recipe;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use FakerRestaurant\Provider\fr_FR\Restaurant;
use Symfony\Component\String\Slugger\SluggerInterface;

class RecipeFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(private readonly SluggerInterface $slugger)
    {
        
    }
    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new Restaurant($faker));

        $categories = ['Entrée', 'Plat', 'Dessert','Goûter'];

        foreach ($categories as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $category->setSlug(strtolower($this->slugger->slug($category->getName())));
            $category->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTime()));
            $category->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->dateTime()));
            $manager->persist($category);
            $this->addReference($categoryName, $category);
        }

        for ($i=0; $i <= 10; $i++) { 
            $recipe = new Recipe();
            $recipe->setTitle($faker->foodName());
            $recipe->setContent($faker->paragraph(10,true));
            $recipe->setSlug(strtolower($this->slugger->slug($recipe->getTitle())));
            $recipe->setDuration($faker->numberBetween(10,120));
            $recipe->setCategory($this->getReference($faker->randomElement($categories),Category::class));
            $recipe->setUser($this->getReference("USER{$faker->numberBetween(1,10)}",User::class));
            $recipe->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTime()));
            $recipe->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->dateTime()));
            $manager->persist($recipe);
        }
        $manager->flush();
    }
}
