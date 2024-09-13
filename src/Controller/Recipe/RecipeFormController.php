<?php

namespace App\Controller\Recipe;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/recipe/form', name: 'recipe_form_')]
class RecipeFormController extends AbstractController
{
    #[Route('/new', name: 'new')]
    public function index(): Response
    {
        return $this->forward(RecipeFormController::class . '::metadata');
    }

    public function metadata(): Response
    {
        return $this->render('pages/recipe/recipe-form/metadata.html.twig');
    }
}
