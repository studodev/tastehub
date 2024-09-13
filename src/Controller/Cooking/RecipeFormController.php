<?php

namespace App\Controller\Cooking;

use App\Entity\Cooking\Recipe;
use App\Form\Type\Cooking\RecipeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    public function metadata(): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);

        return $this->render('pages/cooking/recipe-form/metadata.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
