<?php

namespace App\Service\Common;

use App\Entity\User\ResetPasswordRequest;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

readonly class MailerService
{
    public function __construct(
        private MailerInterface $mailer,
        #[Autowire('%mailer%')] private array $config,
    ) {
    }

    public function sendResetPasswordRequest(ResetPasswordRequest $resetPasswordRequest): bool
    {
        $subject = 'Récupération de votre mot de passe TasteHub';
        $recipient = $resetPasswordRequest->getUser()->getEmail();

        return $this->send($recipient, $subject, 'reset-password-request', [
            'resetPasswordRequest' => $resetPasswordRequest,
        ]);
    }

    private function send(
        string $recipient,
        string $subject,
        string $templateName,
        array $templateContext = [],
        ?string $replyTo = null,
    ): bool {
        $email = new TemplatedEmail();

        $fromAddress = new Address($this->config['sender']['email'], $this->config['sender']['name']);
        $email->from($fromAddress);
        $email->to($recipient);

        if ($replyTo) {
            $email->replyTo($replyTo);
        }

        $email->subject($subject);

        $templatePath = sprintf('%s/%s.html.twig', $this->config['templateFolder'], $templateName);
        $email->htmlTemplate($templatePath);
        $email->context($templateContext);

        try {
            $this->mailer->send($email);

            return true;
        } catch (TransportExceptionInterface) {
            return false;
        }
    }
}
