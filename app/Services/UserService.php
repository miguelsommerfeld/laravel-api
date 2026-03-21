<?php

namespace App\Services;

use App\Http\Requests\UserRegisterRequest;
use App\Models\UserModel;

class UserService {
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = app(UserModel::class);
    }

    public function authentication (UserRegisterRequest $user): bool
    {
        if ($this->userModel->where('email', $user['email'])->exists() === false) {
            $data = [
                'username' => '',
                'email' => trim(strtolower($user['email'])),
                'password' => ''
            ];
        }

        return true;
    }

    public function formatUsername (string $username): string
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