<?php

namespace App\Controller\User;

use App\Enum\Common\FlashMessageTypeEnum;
use App\Form\Type\User\ChangePasswordType;
use App\Form\Type\User\DetailType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/compte', name: 'user_account_')]
#[IsGranted('ROLE_USER')]
class AccountController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    ) {
    }

    #[Route('/informations', name: 'detail')]
    public function detail(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(DetailType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->em->flush();
                $this->addFlash(FlashMessageTypeEnum::Notice->value, 'Les informations de votre compte ont bien été enregistrées');

                return $this->redirectToRoute('user_account_detail');
            }

            $this->em->refresh($user);
        }

        return $this->render('pages/user/account/detail.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/mot-de-passe', name: 'password')]
    public function password(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(null);
            $this->em->flush();
            $this->addFlash(FlashMessageTypeEnum::Notice->value, 'Le mot de passe de votre compte a bien été enregistré');

            return $this->redirectToRoute('user_account_password');
        }

        return $this->render('pages/user/account/password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
