<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Http\JsonResponse;
use App\Services\UserService;

class AuthenticationController extends Controller
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = app(UserService::class);
    }

    public function signUp(AuthRequest $request): JsonResponse
    {
        $response = $this->userService->register($request);

        if (!empty($response['data'])) {
            return response()->json($response['data'], $response['status']);
        }

        return response()->json($response['message'], $response['status']);
    }

    public function signIn(AuthRequest $request): JsonResponse
    {
        $response = $this->userService->logIn($request);

        if (!empty($response['data'])) {
            return response()->json($response['data'], $response['status']);
        }

        return response()->json($response['message'], $response['status']);
    }
}
