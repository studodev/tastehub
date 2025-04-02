<?php

namespace App\Controller\Cooking;

use App\Form\Type\Cooking\RecipeFilterType;
use App\Model\Cooking\RecipeFilter;
use App\Repository\Cooking\RecipeRepository;
use App\Service\Common\PaginationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// TODO - Add filter + empty container
#[Route('/recette', name: 'cooking_recipe_explore_')]
final class RecipeExploreController extends AbstractController
{
    public function __construct(private readonly RecipeRepository $recipeRepository)
    {
    }

    #[Route(name: 'index')]
    public function index(Request $request, PaginationService $paginationService): Response
    {
        $filter = new RecipeFilter();
        $form = $this->createForm(RecipeFilterType::class, $filter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipeQueryBuilder = $this->recipeRepository->findByFilterQueryBuilder($filter);
        } else {
            $recipeQueryBuilder = $this->recipeRepository->findByFilterQueryBuilder();
        }

        $offset = $request->query->getInt('offset');
        $pagination = $paginationService->paginate($recipeQueryBuilder, $offset, 2);

        if ($request->isXmlHttpRequest()) {
            return $this->json([
                'status' => true,
                'view' => $this->renderView('components/cooking/recipe-list.html.twig', [
                    'recipes' => $pagination->getResults(),
                ]),
                'details' => [
                    'offset' => $pagination->getOffset(),
                    'limit' => $pagination->getLimit(),
                    'total' => $pagination->getTotal(),
                ],
            ]);
        }

        return $this->render('pages/cooking/recipe-explore/index.html.twig', [
            'form' => $form->createView(),
            'pagination' => $pagination,
        ]);
    }
}
