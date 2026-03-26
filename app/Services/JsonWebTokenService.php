<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JsonWebTokenService {
    public function gerarJWT(int $time, mixed ...$params): string
    {
        $payload = [
            'iat'   => time(),
            'exp'   => time() + $time,
            'data'  => $params
        ];

        $jwt = JWT::encode($payload, 'SECRETSECRET27SECRETSECRET27SECRETSECRET27SECRETSECRET27SECRETSECRET27', 'HS256');
        return $jwt;
    }
}