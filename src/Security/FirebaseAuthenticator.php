<?php
namespace App\Security;

use App\Repository\ProfesorRepository;
use App\Service\Firebase;
use Lcobucci\JWT\UnencryptedToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport as PassportSelfValidatingPassport;

class FirebaseAuthenticator extends AbstractAuthenticator
{
    private Firebase $firebase;
    private ProfesorRepository $repo;

    public function __construct(Firebase $firebase, ProfesorRepository $repo)
    {
        $this->firebase = $firebase;
        $this->repo     = $repo;
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('Authorization');
    }

    public function authenticate(Request $request): Passport
    {
        $header = $request->headers->get('Authorization', '');
        if (0 !== strpos($header, 'Bearer ')) {
            throw new AuthenticationException('No token found');
        }
        $idToken = substr($header, 7);

        try {
            /** @var UnencryptedToken $verifiedToken */
            $verifiedToken = $this->firebase->verifyIdToken($idToken);
        } catch (\Throwable $e) {
            throw new AuthenticationException('Token inválido');
        }

        $email = $verifiedToken->claims()->get('email');
        if (!$email) {
            throw new AuthenticationException('Email no encontrado en token');
        }

        return new PassportSelfValidatingPassport(
            new UserBadge($email, function(string $userIdentifier) {
                $profesor = $this->repo->findOneBy(['email' => $userIdentifier]);
                if (!$profesor) {
                    throw new AuthenticationException('Usuario no registrado');
                }
                return $profesor;
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new Response('', Response::HTTP_UNAUTHORIZED);
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new Response('', Response::HTTP_UNAUTHORIZED);
    }
}