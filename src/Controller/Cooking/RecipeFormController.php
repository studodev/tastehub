<?php

namespace App\Controller\Cooking;

use App\Entity\Cooking\Recipe;
use App\Form\Type\Cooking\RecipeType;
use App\Service\Cooking\RecipePictureService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/recipe/form', name: 'cooking_recipe_form_')]
class RecipeFormController extends AbstractController
{
    #[Route('/new', name: 'new')]
    public function index(): Response
    {
        return $this->forward(RecipeFormController::class . '::metadata');
    }

    public function metadata(Request $request, RecipePictureService $recipePictureService): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipePictureService->upload($recipe);

            return $this->redirectToRoute('cooking_recipe_form_new');
        }

        return $this->render('pages/cooking/recipe-form/metadata.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
