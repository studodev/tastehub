<?php

namespace App\Controller\Cooking;

use App\Entity\User\User;
use App\Form\Type\Cooking\RecipeFilterType;
use App\Model\Cooking\RecipeFilter;
use App\Repository\Cooking\RecipeRepository;
use App\Service\Common\PaginationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/recette', name: 'cooking_recipe_explore_')]
final class RecipeExploreController extends AbstractController
{
    public function __construct(
        private readonly PaginationService $paginationService,
        private readonly RecipeRepository $recipeRepository,
    ) {
    }

    #[Route(name: 'index')]
    public function index(Request $request): Response
    {
        return $this->renderRecipes($request);
    }

    #[Route('/livre/{slug:user}', name: 'book')]
    public function book(Request $request, User $user): Response
    {
        return $this->renderRecipes($request, $user);
    }

    #[Route('/livre', name: 'my_book')]
    #[IsGranted('ROLE_USER')]
    public function myBook(): Response
    {
        return $this->forward('App\Controller\Cooking\RecipeExploreController::book', [
            'user' => $this->getUser(),
        ]);
    }

    private function renderRecipes(Request $request, ?User $user = null): Response
    {
        $filter = new RecipeFilter();
        $form = $this->createForm(RecipeFilterType::class, $filter);
        $form->handleRequest($request);

        $activeFilter = $form->isSubmitted() && $form->isValid() ? $filter : null;

        if (null !== $user) {
            $recipeQueryBuilder = $this->recipeRepository->findByBookAndFilterQueryBuilder($user, $activeFilter);
        } else {
            $recipeQueryBuilder = $this->recipeRepository->findByFilterQueryBuilder($activeFilter);
        }

        $offset = $request->query->getInt('offset');
        $pagination = $this->paginationService->paginate($recipeQueryBuilder, $offset);

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

        $templateName = $user ? 'book' : 'index';
        $templateExtraParameters = $user ? ['user' => $user] : null;

        return $this->render(sprintf('pages/cooking/recipe-explore/%s.html.twig', $templateName), [
            'form' => $form->createView(),
            'pagination' => $pagination,
            ...$templateExtraParameters ?? [],
        ]);
    }
}
