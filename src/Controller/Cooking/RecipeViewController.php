<?php

namespace App\Controller\Cooking;

use App\Entity\Cooking\Recipe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/recipe', name: 'cooking_recipe_view_')]
class RecipeViewController extends AbstractController
{
    #[Route('/{slug:recipe}', name: 'single')]
    public function single(Recipe $recipe): Response
    {
        return new Response($recipe->getTitle());
    }
}
