<?php

namespace App\DataFixtures\Cooking;

use App\DataFixtures\Common\AbstractFixture;
use App\Entity\Cooking\Ingredient;
use App\Entity\Cooking\IngredientType;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends AbstractFixture implements FixtureGroupInterface, DependentFixtureInterface
{
    private const array INGREDIENTS = [
        [
            'label' => 'Farine de blé',
            '_references' => [
                'type' => [IngredientType::class, 'flour'],
            ],
        ],
        [
            'label' => 'Levure boulangère',
            '_references' => [
                'type' => [IngredientType::class, 'pastry-cooking-helper'],
            ],
        ],
        [
            'label' => 'Eau',
            '_references' => [
                'type' => [IngredientType::class, 'water'],
            ],
        ],
        [
            'label' => 'Beurre demi-sel',
            '_references' => [
                'type' => [IngredientType::class, 'butter'],
            ],
        ],
        [
            'label' => 'Crème fraîche',
            '_references' => [
                'type' => [IngredientType::class, 'dairy-product'],
            ],
        ],
        [
            'label' => 'Œufs',
            '_references' => [
                'type' => [IngredientType::class, 'egg'],
            ],
        ],
        [
            'label' => 'Filet de saumon',
            '_references' => [
                'type' => [IngredientType::class, 'fish'],
            ],
        ],
        [
            'label' => 'Carottes',
            '_references' => [
                'type' => [IngredientType::class, 'vegetables'],
            ],
        ],
        [
            'label' => 'Pommes de terre',
            '_references' => [
                'type' => [IngredientType::class, 'potato'],
            ],
        ],
        [
            'label' => 'Bœuf haché',
            '_references' => [
                'type' => [IngredientType::class, 'meat'],
            ],
        ],
        [
            'label' => 'Filet de poulet',
            '_references' => [
                'type' => [IngredientType::class, 'meat'],
            ],
        ],
        [
            'label' => 'Poivre noir',
            '_references' => [
                'type' => [IngredientType::class, 'spices'],
            ],
        ],
        [
            'label' => 'Sel',
            '_references' => [
                'type' => [IngredientType::class, 'spices'],
            ],
        ],
        [
            'label' => 'Noisettes',
            '_references' => [
                'type' => [IngredientType::class, 'nuts'],
            ],
        ],
        [
            'label' => 'Miel',
            '_references' => [
                'type' => [IngredientType::class, 'honey'],
            ],
        ],
        [
            'label' => 'Huile d\'olive',
            '_references' => [
                'type' => [IngredientType::class, 'oil'],
            ],
        ],
        [
            'label' => 'Pâtes',
            '_references' => [
                'type' => [IngredientType::class, 'pasta'],
            ],
        ],
        [
            'label' => 'Quinoa',
            '_references' => [
                'type' => [IngredientType::class, 'cereals'],
            ],
        ],
        [
            'label' => 'Cheddar',
            '_references' => [
                'type' => [IngredientType::class, 'cheese'],
            ],
        ],
        [
            'label' => 'Tomates cerises',
            '_references' => [
                'type' => [IngredientType::class, 'vegetables'],
            ],
        ],
        [
            'label' => 'Pavé de cabillaud',
            '_references' => [
                'type' => [IngredientType::class, 'fish'],
            ],
        ],
        [
            'label' => 'Lentilles corail',
            '_references' => [
                'type' => [IngredientType::class, 'legumes'],
            ],
        ],
        [
            'label' => 'Pois chiches',
            '_references' => [
                'type' => [IngredientType::class, 'legumes'],
            ],
        ],
        [
            'label' => 'Crevettes roses',
            '_references' => [
                'type' => [IngredientType::class, 'crustaceans'],
            ],
        ],
        [
            'label' => 'Crabe en morceaux',
            '_references' => [
                'type' => [IngredientType::class, 'crustaceans'],
            ],
        ],
        [
            'label' => 'Riz basmati',
            '_references' => [
                'type' => [IngredientType::class, 'cereals'],
            ],
        ],
        [
            'label' => 'Vin rouge',
            '_references' => [
                'type' => [IngredientType::class, 'wine'],
            ],
        ],
        [
            'label' => 'Vin blanc sec',
            '_references' => [
                'type' => [IngredientType::class, 'wine'],
            ],
        ],
        [
            'label' => 'Bière blonde',
            '_references' => [
                'type' => [IngredientType::class, 'beer'],
            ],
        ],
        [
            'label' => 'Bière brune',
            '_references' => [
                'type' => [IngredientType::class, 'beer'],
            ],
        ],
        [
            'label' => 'Sucre roux',
            '_references' => [
                'type' => [IngredientType::class, 'sugar'],
            ],
        ],
        [
            'label' => 'Chocolat noir',
            '_references' => [
                'type' => [IngredientType::class, 'chocolate'],
            ],
        ],
        [
            'label' => 'Chocolat au lait',
            '_references' => [
                'type' => [IngredientType::class, 'chocolate'],
            ],
        ],
        [
            'label' => 'Épinards',
            '_references' => [
                'type' => [IngredientType::class, 'vegetables'],
            ],
        ],
        [
            'label' => 'Courgettes',
            '_references' => [
                'type' => [IngredientType::class, 'vegetables'],
            ],
        ],
        [
            'label' => 'Pommes',
            '_references' => [
                'type' => [IngredientType::class, 'fruits'],
            ],
        ],
        [
            'label' => 'Poires',
            '_references' => [
                'type' => [IngredientType::class, 'fruits'],
            ],
        ],
        [
            'label' => 'Fraises',
            '_references' => [
                'type' => [IngredientType::class, 'fruits'],
            ],
        ],
        [
            'label' => 'Myrtilles',
            '_references' => [
                'type' => [IngredientType::class, 'fruits'],
            ],
        ],
        [
            'label' => 'Confiture de fraises',
            '_references' => [
                'type' => [IngredientType::class, 'pastry-cooking-helper'],
            ],
        ],
        [
            'label' => 'Basilic',
            '_references' => [
                'type' => [IngredientType::class, 'spices'],
            ],
        ],
        [
            'label' => 'Oignons jaunes',
            '_references' => [
                'type' => [IngredientType::class, 'vegetables'],
            ],
        ],
        [
            'label' => 'Ail',
            '_references' => [
                'type' => [IngredientType::class, 'vegetables'],
            ],
        ],
        [
            'label' => 'Pâte feuilletée',
            '_references' => [
                'type' => [IngredientType::class, 'pastry-cooking-helper'],
            ],
        ],
        [
            'label' => 'Chapelure',
            '_references' => [
                'type' => [IngredientType::class, 'pastry-cooking-helper'],
            ],
        ],
        [
            'label' => 'Crème liquide',
            '_references' => [
                'type' => [IngredientType::class, 'dairy-product'],
            ],
        ],
        [
            'label' => 'Saumon fumé',
            '_references' => [
                'type' => [IngredientType::class, 'fish'],
            ],
        ],
        [
            'label' => 'Haricots verts',
            '_references' => [
                'type' => [IngredientType::class, 'vegetables'],
            ],
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::INGREDIENTS as $entry) {
            $ingredient = new Ingredient();
            $this->hydrate($ingredient, $entry);
            $manager->persist($ingredient);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['init', 'ingredient'];
    }

    public function getDependencies(): array
    {
        return [IngredientTypeFixtures::class];
    }
}
