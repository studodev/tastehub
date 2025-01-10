<?php

namespace App\DataFixtures\Cooking;

use App\Entity\Cooking\Ingredient;
use App\Entity\Cooking\IngredientType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    private const INGREDIENTS = [
        [
            'label' => 'Farine de blé',
            'type' => 'flour',
        ],
        [
            'label' => 'Levure boulangère',
            'type' => 'pastry-cooking-helper',
        ],
        [
            'label' => 'Eau',
            'type' => 'water',
        ],
        [
            'label' => 'Beurre demi-sel',
            'type' => 'butter',
        ],
        [
            'label' => 'Crème fraîche',
            'type' => 'dairy-product',
        ],
        [
            'label' => 'Œufs',
            'type' => 'egg',
        ],
        [
            'label' => 'Filet de saumon',
            'type' => 'fish',
        ],
        [
            'label' => 'Carottes',
            'type' => 'vegetables',
        ],
        [
            'label' => 'Pommes de terre',
            'type' => 'potato',
        ],
        [
            'label' => 'Bœuf haché',
            'type' => 'meat',
        ],
        [
            'label' => 'Filet de poulet',
            'type' => 'meat',
        ],
        [
            'label' => 'Poivre noir',
            'type' => 'spices',
        ],
        [
            'label' => 'Sel',
            'type' => 'spices',
        ],
        [
            'label' => 'Noisettes',
            'type' => 'nuts',
        ],
        [
            'label' => 'Miel',
            'type' => 'honey',
        ],
        [
            'label' => 'Huile d’olive',
            'type' => 'oil',
        ],
        [
            'label' => 'Pâtes',
            'type' => 'pasta',
        ],
        [
            'label' => 'Quinoa',
            'type' => 'cereals',
        ],
        [
            'label' => 'Cheddar',
            'type' => 'cheese',
        ],
        [
            'label' => 'Tomates cerises',
            'type' => 'vegetables',
        ],
        [
            'label' => 'Pavé de cabillaud',
            'type' => 'fish',
        ],
        [
            'label' => 'Lentilles corail',
            'type' => 'legumes',
        ],
        [
            'label' => 'Pois chiches',
            'type' => 'legumes',
        ],
        [
            'label' => 'Crevettes roses',
            'type' => 'crustaceans',
        ],
        [
            'label' => 'Crabe en morceaux',
            'type' => 'crustaceans',
        ],
        [
            'label' => 'Riz basmati',
            'type' => 'cereals',
        ],
        [
            'label' => 'Vin rouge',
            'type' => 'wine',
        ],
        [
            'label' => 'Vin blanc sec',
            'type' => 'wine',
        ],
        [
            'label' => 'Bière blonde',
            'type' => 'beer',
        ],
        [
            'label' => 'Bière brune',
            'type' => 'beer',
        ],
        [
            'label' => 'Sucre roux',
            'type' => 'sugar',
        ],
        [
            'label' => 'Chocolat noir',
            'type' => 'chocolate',
        ],
        [
            'label' => 'Chocolat au lait',
            'type' => 'chocolate',
        ],
        [
            'label' => 'Épinards',
            'type' => 'vegetables',
        ],
        [
            'label' => 'Courgettes',
            'type' => 'vegetables',
        ],
        [
            'label' => 'Pommes',
            'type' => 'fruits',
        ],
        [
            'label' => 'Poires',
            'type' => 'fruits',
        ],
        [
            'label' => 'Fraises',
            'type' => 'fruits',
        ],
        [
            'label' => 'Myrtilles',
            'type' => 'fruits',
        ],
        [
            'label' => 'Confiture de fraises',
            'type' => 'pastry-cooking-helper',
        ],
        [
            'label' => 'Basilic',
            'type' => 'spices',
        ],
        [
            'label' => 'Oignons jaunes',
            'type' => 'vegetables',
        ],
        [
            'label' => 'Ail',
            'type' => 'vegetables',
        ],
        [
            'label' => 'Pâte feuilletée',
            'type' => 'pastry-cooking-helper',
        ],
        [
            'label' => 'Chapelure',
            'type' => 'pastry-cooking-helper',
        ],
        [
            'label' => 'Crème liquide',
            'type' => 'dairy-product',
        ],
        [
            'label' => 'Saumon fumé',
            'type' => 'fish',
        ],
        [
            'label' => 'Haricots verts',
            'type' => 'vegetables',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::INGREDIENTS as $entry) {
            $ingredient = new Ingredient();
            $ingredient->setLabel($entry['label']);

            $type = $this->getReference(sprintf('ingredient_type_%s', $entry['type']), IngredientType::class);
            $ingredient->setType($type);

            $manager->persist($ingredient);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['init'];
    }

    public function getDependencies(): array
    {
        return [IngredientTypeFixtures::class];
    }
}
