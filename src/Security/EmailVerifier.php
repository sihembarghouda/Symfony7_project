<?php

namespace App\Security;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailVerifier
{
    private $verifyEmailHelper;
    private $mailer;
    private $router;

    public function __construct(VerifyEmailHelperInterface $verifyEmailHelper, MailerInterface $mailer, UrlGeneratorInterface $router)
    {
        $this->verifyEmailHelper = $verifyEmailHelper;
        $this->mailer = $mailer;
        $this->router = $router;
    }

    public function sendEmailConfirmation(string $userEmail, string $token): void
    {
        // Génère l'URL de confirmation de l'email
        $url = $this->router->generate('app_verify_email', [
            'token' => $token
        ], UrlGeneratorInterface::ABSOLUTE_URL);

        // Crée l'email
        $email = (new Email())
            ->from('noreply@ecommerce.com') // Modifie cette adresse si besoin
            ->to($userEmail)
            ->subject('Please Confirm your Email')
            ->html("<p>Click <a href=\"$url\">here</a> to confirm your email address.</p>");

        // Envoie l'email
        $this->mailer->send($email);
    }
}
