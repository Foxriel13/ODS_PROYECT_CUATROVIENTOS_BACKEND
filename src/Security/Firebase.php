<?php
namespace App\Service;

use Kreait\Firebase\Factory;


class Firebase
{
    private Auth $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function verifyIdToken(string $idToken): UnencryptedToken
    {
        // Lanza excepción si es inválido
        return $this->auth->verifyIdToken($idToken);
    }
}
