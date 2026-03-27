<?php
declare(strict_types=1);

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JsonWebTokenService {
    final string $secret;

    public function __construct()
    {
        $this->secret = env('SECRET_KEY');
    }

    public function generateJWT(int $time, mixed ...$params): string
    {
        $payload = [
            'iat'   => time(),
            'exp'   => time() + $time,
            'data'  => $params
        ];

        $jwt = JWT::encode($payload, $this->secret, 'HS256');
        return $jwt;
    }

    public function validateToken(string $jwt): bool|array
    {
        try {
           $decodedJWT = JWT::decode($jwt, new Key($this->secret, 'HS256'));

            if ($decodedJWT->exp > time()) {
                return true;
            }

            return false;
        } catch (\Exception) {
            return [
                'status'  => 401,
                'message' => 'O JWT inserido é inválido'
            ];
        }
    }
}