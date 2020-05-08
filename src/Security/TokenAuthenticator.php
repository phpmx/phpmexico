<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function supports(Request $request)
    {
        return $request->query->get('token', false);
    }

    public function getCredentials(Request $request)
    {
        return [
            'login_token' => $request->query->get('token'),
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = $credentials['login_token'];

        if (null === $token) {
            return false;
        }

        $user = $this->em->getRepository(User::class)
            ->findByToke($token);

        // if a User object, checkCredentials() is called
        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new RedirectResponse('/login');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        /** @var User $user */
        $user = $token->getUser();
        $user->setLoginToken(null);
        $this->em->persist($user);
        $this->em->flush();

        return new RedirectResponse('/profile');
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse('/login');
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
