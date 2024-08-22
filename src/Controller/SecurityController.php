<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\ChangePasswordType;
use App\Form\Type\RegisterType;
use App\Form\Type\ResetPasswordRequestType;
use App\Service\ResetPasswordService;
use App\Util\FlashMessageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('', name: 'security_')]
#[IsGranted('NOT_CONNECTED')]
class SecurityController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ResetPasswordService $resetPasswordService
    ) {
    }

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

    #[Route('/register', name: 'register')]
    public function register(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('pages/security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/reset-password', name: 'reset_password_request')]
    public function resetPasswordRequest(Request $request): Response
    {
        $form = $this->createForm(ResetPasswordRequestType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $this->resetPasswordService->request($email);

            return $this->redirectToRoute('security_reset_password_request', [
                'status' => true,
            ]);
        }

        return $this->render('pages/security/reset-password-request.html.twig', [
            'status' => $request->query->get('status'),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/reset-password/{token}', name: 'reset_password')]
    public function resetPassword(Request $request, string $token): Response
    {
        $resetPasswordRequest = $this->resetPasswordService->retrieveRequest($token);

        if (!$resetPasswordRequest) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(ChangePasswordType::class, $resetPasswordRequest->getUser());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $resetPasswordRequest->getUser()->setPassword(null);
            $this->em->remove($resetPasswordRequest);
            $this->em->flush();

            $this->addFlash(FlashMessageType::Notice->value, 'Votre mot de passe a bien été modifié');

            return $this->redirectToRoute('security_login');
        }

        return $this->render('pages/security/reset-password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
