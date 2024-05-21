<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('', name: 'security_')]
class SecurityController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUserIdentifier = $authenticationUtils->getLastUsername();

        return $this->render('pages/security/login.html.twig', [
            'lastUserIdentifier' => $lastUserIdentifier,
            'error' => $error,
        ]);
    }
}
