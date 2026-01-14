<?php

namespace App\DataFixtures\Cooking;

use App\DataFixtures\Common\AbstractFixture;
use App\Entity\Cooking\CookingMethod;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CookingMethodFixtures extends AbstractFixture implements FixtureGroupInterface
{
    private const array METHODS = [
        [
            'label' => 'Pas de cuisson',
            'icon' => 'no-cooking',
            'singular' => true,
        ],
        [
            'label' => 'Plaques de cuisson',
            'icon' => 'baking-tray',
        ],
        [
            'label' => 'Four',
            'icon' => 'oven',
        ],
        [
            'label' => 'Friture',
            'icon' => 'fryer',
        ],
        [
            'label' => 'Vapeur',
            'icon' => 'steam',
        ],
        [
            'label' => 'Grillade / Plancha',
            'icon' => 'grill',
        ],
        [
            'label' => 'Micro-ondes',
            'icon' => 'microwave',
        ],
        [
            'label' => 'Croque-Gaufrier',
            'icon' => 'waffle-iron',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::METHODS as $entry) {
            $method = new CookingMethod();
            $this->hydrate($method, $entry);
            $manager->persist($method);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['init', 'cooking_method'];
    }
}
