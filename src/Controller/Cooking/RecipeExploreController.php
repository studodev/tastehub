<?php

namespace App\Controller\Cooking;

use App\Enum\Cooking\RecipeStateEnum;
use App\Form\Type\Cooking\RecipeFilterType;
use App\Model\Cooking\RecipeFilter;
use App\Repository\Cooking\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/recette', name: 'cooking_recipe_explore_')]
final class RecipeExploreController extends AbstractController
{
    public function __construct(private readonly RecipeRepository $recipeRepository)
    {
    }

    #[Route(name: 'index')]
    public function index(Request $request): Response
    {
        $filter = new RecipeFilter();
        $form = $this->createForm(RecipeFilterType::class, $filter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // TODO
        }

        $recipes = $this->recipeRepository->findBy([
            'state' => RecipeStateEnum::Published,
        ]);

        return $this->render('pages/cooking/recipe-explore/index.html.twig', [
            'form' => $form->createView(),
            'recipes' => $recipes,
        ]);
    }
}
