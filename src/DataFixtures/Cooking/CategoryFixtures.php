<?php

namespace App\DataFixtures\Cooking;

use App\DataFixtures\Common\AbstractFixture;
use App\Entity\Cooking\Category;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends AbstractFixture implements FixtureGroupInterface
{
    private const array CATEGORIES = [
        [
            'label' => 'Amuse bouche',
        ],
        [
            'label' => 'Entrée',
        ],
        [
            'label' => 'Plat',
        ],
        [
            'label' => 'Dessert',
        ],
        [
            'label' => 'Sauce',
        ],
        [
            'label' => 'Boisson',
        ],
        [
            'label' => 'Condiment',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORIES as $entry) {
            $category = new Category();
            $this->hydrate($category, $entry);
            $manager->persist($category);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['init', 'category'];
    }
}
