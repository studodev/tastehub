<?php

namespace App\Service;

use App\Entity\ResetPasswordRequest;
use App\Repository\UserRepository;
use App\Util\SecurityUtil;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class ResetPasswordService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserRepository $userRepository,
        #[Autowire('%reset_password%')] private readonly array $config
    ) {
    }

    public function request(string $email): void
    {
        $user = $this->userRepository->findOneBy([
            'email' => $email
        ]);

        if (!$user) {
            return;
        }

        $request = new ResetPasswordRequest();
        $request->setUser($user);

        $expireAt = new DateTimeImmutable(sprintf('%s hours', $this->config['token_lifetime']));
        $request->setExpireAt($expireAt);

        $token = SecurityUtil::generateToken();
        $selector = substr($token, 0, 20);
        $request->setSelector($selector);

        $hashedToken = hash('sha256', $token);
        $request->setHashedToken($hashedToken);

        $this->em->persist($request);
        $this->em->flush();

        // TODO - Send mail
    }
}
