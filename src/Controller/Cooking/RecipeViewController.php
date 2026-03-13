<?php

namespace App\Controller\Cooking;

use App\Entity\Cooking\Recipe;
use App\Form\Type\Cooking\QuantityCounterType;
use App\Service\Cooking\RecipeCustomizerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/recette', name: 'cooking_recipe_view_')]
class RecipeViewController extends AbstractController
{
    public function __construct(private readonly RecipeCustomizerService $recipeCustomizerService)
    {
    }

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

    #[Route('/{slug:recipe}/personnaliser', name: 'customize')]
    public function customaize(Request $request, Recipe $recipe): Response
    {
        $quantity = $request->query->getInt('quantity', 1);

        $this->recipeCustomizerService->customizeCounter($recipe, $quantity);

        return $this->json([
            'status' => true,
            'views' => [
                'ingredient' => $this->renderView('components/cooking/ingredient-list.html.twig', [
                    'recipeIngredients' => $recipe->getRecipeIngredients(),
                ]),
                'step' => $this->renderView('components/cooking/step-list.html.twig', [
                    'steps' => $recipe->getSteps(),
                ]),
            ],
        ]);
    }
}
