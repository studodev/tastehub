<?php

namespace App\Controller\Cooking;

use App\Repository\Cooking\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tag', name: 'cooking_tag_')]
class TagController extends AbstractController
{
    public function __construct(private readonly TagRepository $tagRepository)
    {
    }

    #[Route('/autocomplete', name: 'autocomplete')]
    public function autocomplete(Request $request): Response
    {
        $query = $request->query->get('query', '');
        $tags = $this->tagRepository->autocomplete($query);

        return $this->json([
            'items' => $tags,
        ]);
    }
}
