<?php

namespace App\Security\EntryPoint;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

final readonly class MainEntryPoint implements AuthenticationEntryPointInterface
{
    private const string LOGIN_ROUTE = 'user_security_login';
    private const string DEFAULT_DESTINATION_ROUTE = 'main_index';

    public function __construct(
        private Security $security,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function start(Request $request, ?AuthenticationException $authException = null): Response
    {
        if (null !== $this->security->getUser()) {
            $url = $this->urlGenerator->generate(self::DEFAULT_DESTINATION_ROUTE);
        } else {
            $url = $this->urlGenerator->generate(self::LOGIN_ROUTE);
        }

        return new RedirectResponse($url);
    }
}
