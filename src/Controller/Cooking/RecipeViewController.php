<?php

namespace App\Controller\Cooking;

use App\Entity\Cooking\Recipe;
use App\Entity\Cooking\Review;
use App\Form\Type\Cooking\QuantityCounterType;
use App\Form\Type\Cooking\ReviewType;
use App\Security\Voter\Cooking\ReviewVoter;
use App\Service\Cooking\RecipeCustomizerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/recette', name: 'cooking_recipe_view_')]
class RecipeViewController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly RecipeCustomizerService $recipeCustomizerService,
    ) {
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
    public function customize(Request $request, Recipe $recipe): Response
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

    #[Route('/{slug:recipe}/avis/deposer', name: 'reviewForm')]
    #[IsGranted(ReviewVoter::ATTRIBUTE_CREATE, 'recipe')]
    public function reviewForm(Request $request, Recipe $recipe): Response
    {
        $review = new Review();
        $review->setRecipe($recipe);
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $review->setUser($this->getUser());
            $this->em->persist($review);
            $this->em->flush();

            return $this->json([
                'status' => true,
                'view' => $this->renderView('components/cooking/form/review-form.html.twig', [
                    'recipe' => $recipe,
                    'success' => true,
                ]),
            ]);
        }

        return $this->json([
            'status' => true,
            'view' => $this->renderView('components/cooking/form/review-form.html.twig', [
                'recipe' => $recipe,
                'form' => $form->createView(),
            ]),
        ]);
    }
}
