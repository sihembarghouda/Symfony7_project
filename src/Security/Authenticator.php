<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class Authenticator extends AbstractAuthenticator
{
    use TargetPathTrait;

    public function supports(Request $request): ?bool
    {
        // Vérifie si la demande concerne la route de connexion et si la méthode est POST
        return $request->attributes->get('_route') === 'app_connexion' && $request->isMethod('POST');
    }

    public function authenticate(Request $request): Passport
    {
        // Récupère les informations de l'utilisateur depuis la requête (email et mot de passe)
        $email = $request->request->get('email', '');
        $password = $request->request->get('password', '');

        // Crée un Passport pour l'utilisateur avec un badge d'email et un badge de mot de passe
        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($password),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Si l'authentification réussit, redirige l'utilisateur vers la page cible, sinon vers la page d'accueil
        $targetPath = $this->getTargetPath($request->getSession(), $firewallName);

        if ($targetPath) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse('/');
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        // Si l'authentification échoue, affiche un message d'erreur et redirige vers la page de connexion
        $request->getSession()->getFlashBag()->add('error', 'Invalid credentials.');

        return new RedirectResponse('/connexion');
    }
}
