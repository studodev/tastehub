<?php

namespace App\Controller\Cooking;

use App\Repository\Cooking\UtensilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/utensil', name: 'cooking_utensil_')]
class UtensilController extends AbstractController
{
    public function __construct(private readonly UtensilRepository $utensilRepository)
    {
    }

    #[Route('/autocomplete', name: 'autocomplete')]
    public function autocomplete(Request $request): Response
    {
        $query = $request->query->get('query', '');
        $utensils = $this->utensilRepository->autocomplete($query);

        return $this->json([
            'items' => $utensils,
        ]);
    }
}
