<?php

namespace App\Security\Handler;

use App\Security\Exception\RedirectAccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

final readonly class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        if ($accessDeniedException instanceof RedirectAccessDeniedException) {
            return $this->handleRedirect($accessDeniedException);
        }

        return null;
    }

    private function handleRedirect(RedirectAccessDeniedException $accessDeniedException): RedirectResponse
    {
        $url = $this->urlGenerator->generate($accessDeniedException->getRedirectRoute(), $accessDeniedException->getRedirectRouteParams());

        return new RedirectResponse($url);
    }
}
