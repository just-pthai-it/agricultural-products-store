<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterFormRequest;
use App\Services\Contracts\AuthServiceContract;

class AuthController extends Controller
{
    private AuthServiceContract $authService;

    /**
     * @param AuthServiceContract $authService
     */
    public function __construct (AuthServiceContract $authService)
    {
        $this->authService = $authService;
    }

    public function register (RegisterFormRequest $request)
    {
        return $this->authService->register($request->validated());
    }

    public function login (LoginFormRequest $request)
    {
        return $this->authService->login($request->validated());
    }

    public function logout (Request $request, string $options = '')
    {
        $this->authService->logout($options);
    }
}
