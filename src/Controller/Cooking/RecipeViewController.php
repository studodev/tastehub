<?php

namespace App\Controller\Cooking;

use App\Entity\Cooking\Recipe;
use App\Form\Type\Cooking\QuantityCounterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/recette', name: 'cooking_recipe_view_')]
class RecipeViewController extends AbstractController
{
    #[Route('/{slug:recipe}', name: 'single')]
    public function single(Recipe $recipe): Response
    {
        $quantiyForm = $this->createForm(QuantityCounterType::class, $recipe->getQuantityCounter(), [
            'mode' => QuantityCounterType::MODE_VIEW,
        ]);

        return $this->render('pages/cooking/recipe-view/single.html.twig', [
            'recipe' => $recipe,
            'quantityForm' => $quantiyForm->createView(),
        ]);
    }
}
