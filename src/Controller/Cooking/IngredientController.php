<?php

namespace App\Controller\Cooking;

use App\Enum\Common\PictogramTypeEnum;
use App\Repository\Cooking\IngredientRepository;
use App\Service\Common\PictogramService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ingredient', name: 'cooking_ingredient_')]
class IngredientController extends AbstractController
{
    public function __construct(
        private readonly IngredientRepository $ingredientRepository,
        private readonly PictogramService $pictogramService,
    ) {
    }

    #[Route('/autocomplete', name: 'autocomplete')]
    public function autocomplete(Request $request): Response
    {
        $query = $request->query->get('query', '');
        $ingredients = $this->ingredientRepository->autocomplete($query);

        foreach ($ingredients as &$ingredient) {
            $ingredient['data:pictogram'] = $this->pictogramService->buildUrl(PictogramTypeEnum::Ingredient, $ingredient['data:pictogram']);
        }

        return $this->json([
            'items' => $ingredients,
        ]);
    }
}
