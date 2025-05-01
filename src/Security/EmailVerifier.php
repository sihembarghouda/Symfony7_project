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
        // Génère l'URL de confirmation d'email avec le token pour le lien de vérification
        $url = $this->router->generate('app_verify_email', [
            'token' => $token
        ], UrlGeneratorInterface::ABSOLUTE_URL);

        // Crée l'email à envoyer
        $email = (new Email())
            ->from('noreply@ecommerce.com') // Adresse email de l'expéditeur
            ->to($userEmail) // Adresse email du destinataire
            ->subject('Please Confirm your Email') // Sujet de l'email
            ->html("<p>Click <a href=\"$url\">here</a> to confirm your email address.</p>"); // Corps de l'email

        // Envoie l'email
        $this->mailer->send($email);
    }
}
