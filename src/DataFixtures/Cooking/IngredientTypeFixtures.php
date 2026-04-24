<?php

namespace App\DataFixtures\Cooking;

use App\DataFixtures\Common\AbstractFixture;
use App\Entity\Cooking\IngredientType;
use App\Service\Common\JsonDataLoader;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class IngredientTypeFixtures extends AbstractFixture implements FixtureGroupInterface
{
    public function __construct(private readonly JsonDataLoader $jsonDataLoader)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $ingredientTypes = $this->jsonDataLoader->load('ingredient-types');

        foreach ($ingredientTypes as $key => $entry) {
            $type = new IngredientType();
            $this->hydrate($type, $entry);
            $this->addReference($key, $type);
            $manager->persist($type);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['init', 'ingredient_type'];
    }
}
