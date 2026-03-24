<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JsonWebTokenService {
    public function gerarJWTLogin(int $time, int $id, string $email): string
    {
        $payload = [
            'iat'   => time(),
            'exp'   => time() + $time,
            'id'    => $id,
            'email' => $email
        ];

        $jwt = JWT::encode($payload, 'SECRETSECRET27SECRETSECRET27SECRETSECRET27SECRETSECRET27SECRETSECRET27', 'HS256');
        return $jwt;
    }
}