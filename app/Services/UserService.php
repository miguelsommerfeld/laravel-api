<?php

namespace App\Services;

use App\Http\Requests\UserRegisterRequest;
use App\Models\UserModel;
use App\Services\JsonWebTokenService;

class UserService {
    private UserModel $userModel;
    protected JsonWebTokenService $jsonWebTokenService;

    public function __construct()
    {
        $this->userModel = app(UserModel::class);
        $this->jsonWebTokenService = app(JsonWebTokenService::class);
    }

    public function signUp(UserRegisterRequest $user): array
    {
        if ($this->userModel->where('email', $user->email)->exists()) {
            return [
                'status'  => 403,
                'message' => 'O endereço de e-mail já está cadastrado no sistema.'
            ];
        }

        $data = [
            'username' => $this->formatUsername($user->username),
            'email'    => trim(strtolower($user->email)),
            'password' => trim($user->password)
        ];

        if ($this->userModel->create($data)) {
            $userId = $this->userModel->where('email', $user->email)->value('id'); // RETORNA APENAS O VALOR, NÃO O OBJETO.

            // CRIAÇÃO DO JWT PARA CADASTRAR NO BANCO E RETORNAR AO CONTROLLER
            $jwt = [
                'access_token'  => $this->jsonWebTokenService->gerarJWTLogin(1200, $userId, $user->email), // 20 MINUTOS
                'refresh_token' => $this->jsonWebTokenService->gerarJWTLogin(86400, $userId, $user->email) // 24 HORAS
            ];

            // ATUALIZANDO CAMPOS DE TOKEN DO USUÁRIO
            $this->updateUserData($userId, $jwt);

            return [
                'status' => 201,
                'data'   => $jwt
            ];
        }

        return [
            'status' => 500,
            'message' => 'Ocorreu um erro no servidor. Tente novamente.'
        ];
    }

    public function updateUserData(string $userId, array $data): bool|string
    {
        // SE EXISTIR UM USUÁRIO COM ESSE ID, ELE RETORNA VERDADEIRO.
        if ($this->userModel->where('id', $userId)->exists()){
            // SE O UPDATE OCORRER CORRETAMENTE, ELE RETORNA VERDADEIRO, CASO CONTRÁRIO, RETORNA FALSO.
            if ($this->userModel->where('id', $userId)->update($data)) {
                return true;
            }

            return false;
        }

        return "Usuário não encontrado.";
    }

    private function formatUsername(string $username): string
    {
        if (strpos($username, ' ')) { 
            $fullname = explode(' ', $username);
            
            foreach ($fullname as $key => $value) {
                $fullname[$key] = ucfirst($value);
            }

            return implode(' ', $fullname);
        }

        return ucfirst($username);
    }
}