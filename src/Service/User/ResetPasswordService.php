<?php

namespace App\Service\User;

use App\Entity\User\ResetPasswordRequest;
use App\Repository\User\ResetPasswordRequestRepository;
use App\Repository\User\UserRepository;
use App\Service\MailerService;
use App\Util\User\SecurityUtil;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

readonly class ResetPasswordService
{
    public function __construct(
        private EntityManagerInterface $em,
        private MailerService $mailerService,
        private ResetPasswordRequestRepository $resetPasswordRequestRepository,
        private UserRepository $userRepository,
        #[Autowire('%reset_password%')] private array $config,
    ) {
    }

    public function request(string $email): void
    {
        $user = $this->userRepository->findOneBy([
            'email' => $email,
        ]);

        if (!$user) {
            return;
        }

        $request = new ResetPasswordRequest();
        $request->setUser($user);

        $expireAt = new DateTimeImmutable(sprintf('%s hours', $this->config['token_lifetime']));
        $request->setExpireAt($expireAt);

        $token = SecurityUtil::generateToken();
        $request->setToken($token);

        $selector = $this->extractSelector($token);
        $request->setSelector($selector);

        $hashedToken = $this->hashToken($token);
        $request->setHashedToken($hashedToken);

        $this->em->persist($request);
        $this->em->flush();

        $this->mailerService->sendResetPasswordRequest($request);
    }

    public function retrieveRequest(string $token): ?ResetPasswordRequest
    {
        $selector = $this->extractSelector($token);
        $resetPasswordRequest = $this->resetPasswordRequestRepository->findOneBy([
            'selector' => $selector,
        ]);

        if (!$resetPasswordRequest) {
            return null;
        }

        $hashedToken = $this->hashToken($token);
        if ($hashedToken !== $resetPasswordRequest->getHashedToken()) {
            return null;
        }

        $now = new DateTimeImmutable();
        if ($now > $resetPasswordRequest->getExpireAt()) {
            $this->em->remove($resetPasswordRequest);
            $this->em->flush();

            return null;
        }

        return $resetPasswordRequest;
    }

    private function extractSelector(string $token): string
    {
        return substr($token, 0, 20);
    }

    private function hashToken(string $token): string
    {
        return hash('sha256', $token);
    }
}
