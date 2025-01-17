<?php

namespace App\Controller\Cooking;

use App\Entity\Cooking\Step;
use App\Enum\Cooking\DraftRecipeStatusEnum;
use App\Form\Type\Cooking\RecipeType;
use App\Model\Cooking\DraftRecipe;
use App\Service\Cooking\DraftRecipeService;
use App\Service\Cooking\RecipePictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

#[Route('/recipe/form', name: 'cooking_recipe_form_')]
class RecipeFormController extends AbstractController
{
    public function __construct(
        private readonly DraftRecipeService $draftRecipeService,
        private readonly EntityManagerInterface $em,
        private readonly Environment $twig,
        private readonly RecipePictureService $recipePictureService,
    ) {
    }

    #[Route('/new', name: 'new')]
    public function index(Request $request): Response
    {
        $draft = $this->draftRecipeService->retrieve();
        $this->twig->addGlobal('draft', $draft);

        $method = match ($draft->getStatus()) {
            DraftRecipeStatusEnum::Metadata => 'metadata',
            DraftRecipeStatusEnum::Details => 'details',
            DraftRecipeStatusEnum::Ingredients => 'ingredients',
            DraftRecipeStatusEnum::Utensils => 'utensils',
            DraftRecipeStatusEnum::Steps => 'steps',
        };

        return $this->forward(sprintf('%s::%s', RecipeFormController::class, $method), [
            'request' => $request,
            'draft' => $draft,
        ]);
    }

    public function metadata(Request $request, DraftRecipe $draft): Response
    {
        $recipe = $draft->getRecipe();
        $form = $this->createForm(RecipeType::class, $recipe, [
            'mode' => $draft->getStatus(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->recipePictureService->upload($recipe);

            $this->em->persist($recipe);
            $this->em->flush();

            $draft->setStatus(DraftRecipeStatusEnum::Details);
            $this->draftRecipeService->update($draft);

            return $this->redirectToRoute('cooking_recipe_form_new');
        }

        return $this->render('pages/cooking/recipe-form/metadata.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function details(Request $request, DraftRecipe $draft): Response
    {
        $recipe = $draft->getRecipe();
        $form = $this->createForm(RecipeType::class, $recipe, [
            'mode' => $draft->getStatus(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipe->setQuantityCounter(clone $recipe->getQuantityCounter());
            $recipe->setTimer(clone $recipe->getTimer());
            $this->em->flush();

            $draft->setStatus(DraftRecipeStatusEnum::Ingredients);
            $this->draftRecipeService->update($draft);

            return $this->redirectToRoute('cooking_recipe_form_new');
        }

        return $this->render('pages/cooking/recipe-form/details.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function ingredients(Request $request, DraftRecipe $draft): Response
    {
        $recipe = $draft->getRecipe();
        $form = $this->createForm(RecipeType::class, $recipe, [
            'mode' => $draft->getStatus(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            $draft->setStatus(DraftRecipeStatusEnum::Utensils);
            $this->draftRecipeService->update($draft);

            return $this->redirectToRoute('cooking_recipe_form_new');
        }

        return $this->render('pages/cooking/recipe-form/ingredients.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function utensils(Request $request, DraftRecipe $draft): Response
    {
        $recipe = $draft->getRecipe();
        $form = $this->createForm(RecipeType::class, $recipe, [
            'mode' => $draft->getStatus(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            $draft->setStatus(DraftRecipeStatusEnum::Steps);
            $this->draftRecipeService->update($draft);

            return $this->redirectToRoute('cooking_recipe_form_new');
        }

        return $this->render('pages/cooking/recipe-form/utensils.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function steps(Request $request, DraftRecipe $draft): Response
    {
        $recipe = $draft->getRecipe();
        $recipe->addStep(new Step());

        $form = $this->createForm(RecipeType::class, $recipe, [
            'mode' => $draft->getStatus(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('cooking_recipe_form_new');
        }

        return $this->render('pages/cooking/recipe-form/steps.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
