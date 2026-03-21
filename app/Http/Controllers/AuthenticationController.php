<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\Request;
use App\Services\UserService;

class AuthenticationController extends Controller
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = app(UserService::class);
    }

    public function register(UserRegisterRequest $request): void
    {
        //
    }
}
