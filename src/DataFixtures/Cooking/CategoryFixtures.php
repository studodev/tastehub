<?php

namespace App\DataFixtures\Cooking;

use App\Entity\Cooking\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture implements FixtureGroupInterface
{
    private const CATEGORIES = [
        'Amuse bouche', 'Entrée', 'Plat', 'Dessert', 'Sauce', 'Boisson',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORIES as $entry) {
            $category = new Category();
            $category->setLabel($entry);
            $manager->persist($category);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['init'];
    }
}
