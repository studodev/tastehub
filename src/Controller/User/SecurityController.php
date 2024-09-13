<?php

namespace App\Controller\User;

use App\Entity\User\User;
use App\Enum\FlashMessageTypeEnum;
use App\Form\Type\User\ChangePasswordType;
use App\Form\Type\User\RegisterType;
use App\Form\Type\User\ResetPasswordRequestType;
use App\Service\User\ResetPasswordService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('', name: 'user_security_')]
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

        return $this->render('pages/user/security/login.html.twig', [
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

            return $this->redirectToRoute('user_security_login');
        }

        return $this->render('pages/user/security/register.html.twig', [
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

            return $this->redirectToRoute('user_security_reset_password_request', [
                'status' => true,
            ]);
        }

        return $this->render('pages/user/security/reset-password-request.html.twig', [
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

            $this->addFlash(FlashMessageTypeEnum::NOTICE->value, 'Votre mot de passe a bien été modifié');

            return $this->redirectToRoute('user_security_login');
        }

        return $this->render('pages/user/security/reset-password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
