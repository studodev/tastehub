<?php

namespace App\DataFixtures\Cooking;

use App\Entity\Cooking\Utensil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class UtensilFixtures extends Fixture implements FixtureGroupInterface
{
    private const UTENSILS = [
        [
            'label' => 'Bol',
            'pictogram' => 'bowl.svg'
        ],
        [
            'label' => 'Tamis',
            'pictogram' => 'kitchen-sieve.svg'
        ],
        [
            'label' => 'Maryse',
            'pictogram' => 'spatula.svg'
        ],
        [
            'label' => 'Spatule',
            'pictogram' => 'spatula.svg'
        ],
        [
            'label' => 'Moule à gâteau',
            'pictogram' => 'cake-mold.svg'
        ],
        [
            'label' => 'Couteau',
            'pictogram' => 'knife.svg'
        ],
        [
            'label' => 'Cuillère',
            'pictogram' => 'spoon.svg'
        ],
        [
            'label' => 'Emporte-pièce',
            'pictogram' => 'cookie-cutter.svg'
        ],
        [
            'label' => 'Louche',
            'pictogram' => 'ladle.svg'
        ],
        [
            'label' => 'Passoire',
            'pictogram' => 'strainer.svg'
        ],
        [
            'label' => 'Planche à découper',
            'pictogram' => 'cutting-board.svg'
        ],
        [
            'label' => 'Casserole',
            'pictogram' => 'pan.svg'
        ],
        [
            'label' => 'Thermomètre',
            'pictogram' => 'thermometer.svg'
        ],
        [
            'label' => 'Poêle à frire',
            'pictogram' => 'frying-pan.svg'
        ],
        [
            'label' => 'Rouleau à pâtisserie',
            'pictogram' => 'pastry-roll.svg'
        ],
        [
            'label' => 'Pince de cuisine',
            'pictogram' => 'tongs.svg'
        ],
        [
            'label' => 'Râpe',
            'pictogram' => 'grater.svg'
        ],
        [
            'label' => 'Poche à douille',
            'pictogram' => 'piping-bag.svg'
        ],
        [
            'label' => 'Épluche-légumes',
            'pictogram' => 'vegetable-peeler.svg'
        ],
        [
            'label' => 'Mixeur plongeant',
            'pictogram' => 'household-appliances.svg'
        ],
        [
            'label' => 'Mixeur',
            'pictogram' => 'household-appliances.svg'
        ],
        [
            'label' => 'Blender',
            'pictogram' => 'household-appliances.svg'
        ],
        [
            'label' => 'Hachoir',
            'pictogram' => 'household-appliances.svg'
        ],
        [
            'label' => 'Grille',
            'pictogram' => 'rack.svg'
        ],
        [
            'label' => 'Fouet',
            'pictogram' => 'whisk.svg'
        ],
        [
            'label' => 'Moules individuels',
            'pictogram' => 'individual-molds.svg'
        ],
        [
            'label' => 'Shaker',
            'pictogram' => 'shaker.svg'
        ],
        [
            'label' => 'Wok',
            'pictogram' => 'wok.svg'
        ],
        [
            'label' => 'Balance de cuisine',
            'pictogram' => 'kitchen-scale.svg'
        ],
        [
            'label' => 'Écumoire',
            'pictogram' => 'skimmer.svg'
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::UTENSILS as $entry) {
            $utensil = new Utensil();
            $utensil->setLabel($entry['label']);
            $utensil->setPictogram($entry['pictogram']);

            $manager->persist($utensil);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['init'];
    }
}
