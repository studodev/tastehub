<?php

namespace App\Controller\Cooking;

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
        return $this->render('pages/cooking/recipe-form/metadata.html.twig');
    }
}
