<?php

namespace App\DataFixtures\Cooking;

use App\Entity\Cooking\IngredientType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class IngredientTypeFixtures extends Fixture implements FixtureGroupInterface
{
    private const TYPES = [
        'beer' => [
            'label' => 'Bière',
            'pictogram' => 'beer.svg',
        ],
        'butter' => [
            'label' => 'Beurre',
            'pictogram' => 'butter.svg',
        ],
        'cereals' => [
            'label' => 'Céréales',
            'pictogram' => 'cereals.svg',
        ],
        'cheese' => [
            'label' => 'Fromage',
            'pictogram' => 'cheese.svg',
        ],
        'chocolate' => [
            'label' => 'Chocolat',
            'pictogram' => 'chocolate.svg',
        ],
        'condiment' => [
            'label' => 'Condiment',
            'pictogram' => 'condiment.svg',
        ],
        'crustaceans' => [
            'label' => 'Crustacés',
            'pictogram' => 'crustaceans.svg',
        ],
        'dairy-product' => [
            'label' => 'Produit laitier',
            'pictogram' => 'dairy-product.svg',
        ],
        'egg' => [
            'label' => 'Œuf',
            'pictogram' => 'egg.svg',
        ],
        'fish' => [
            'label' => 'Poisson',
            'pictogram' => 'fish.svg',
        ],
        'flour' => [
            'label' => 'Farine',
            'pictogram' => 'flour.svg',
        ],
        'frozen' => [
            'label' => 'Surgelé',
            'pictogram' => 'frozen.svg',
        ],
        'fruits' => [
            'label' => 'Fruits',
            'pictogram' => 'fruits.svg',
        ],
        'honey' => [
            'label' => 'Miel',
            'pictogram' => 'honey.svg',
        ],
        'legumes' => [
            'label' => 'Légumineuses',
            'pictogram' => 'legumes.svg',
        ],
        'meat' => [
            'label' => 'Viande',
            'pictogram' => 'meat.svg',
        ],
        'nuts' => [
            'label' => 'Noix',
            'pictogram' => 'nuts.svg',
        ],
        'oil' => [
            'label' => 'Huile',
            'pictogram' => 'oil.svg',
        ],
        'pasta' => [
            'label' => 'Pâtes',
            'pictogram' => 'pasta.svg',
        ],
        'pastry-cooking-helper' => [
            'label' => 'Aide à la pâtisserie',
            'pictogram' => 'pastry-cooking-helper.svg',
        ],
        'potato' => [
            'label' => 'Pomme de terre',
            'pictogram' => 'potato.svg',
        ],
        'spices' => [
            'label' => 'Épices',
            'pictogram' => 'spices.svg',
        ],
        'sugar' => [
            'label' => 'Sucre',
            'pictogram' => 'sugar.svg',
        ],
        'vegetables' => [
            'label' => 'Légumes',
            'pictogram' => 'vegetables.svg',
        ],
        'water' => [
            'label' => 'Eau',
            'pictogram' => 'water.svg',
        ],
        'wine' => [
            'label' => 'Vin',
            'pictogram' => 'wine.svg',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::TYPES as $key => $entry) {
            $type = new IngredientType();
            $type->setLabel($entry['label']);
            $type->setPictogram($entry['pictogram']);

            $this->addReference(sprintf('ingredient_type_%s', $key), $type);
            $manager->persist($type);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['init'];
    }
}
