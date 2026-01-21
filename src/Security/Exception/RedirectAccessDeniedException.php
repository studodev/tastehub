<?php

namespace App\Security\Exception;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Throwable;

final class RedirectAccessDeniedException extends AccessDeniedException
{
    public function __construct(
        private readonly string $redirectRoute,
        private readonly array $redirectRouteParams = [],
        string $message = '',
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $previous);
    }

    public function getRedirectRoute(): string
    {
        return $this->redirectRoute;
    }

    public function getRedirectRouteParams(): array
    {
        return $this->redirectRouteParams;
    }
}
