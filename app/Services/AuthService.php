<?php

namespace App\Services;

use Illuminate\Auth\AuthenticationException;
use App\Services\Contracts\UserServiceContract;

class AuthService implements Contracts\AuthServiceContract
{
    private UserServiceContract $userService;

    /**
     * @param UserServiceContract $userService
     */
    public function __construct (UserServiceContract $userService)
    {
        $this->userService = $userService;
    }

    public function register (array $inputs)
    {
        // TODO: Implement register() method.
    }

    /**
     * @throws AuthenticationException
     */
    public function login (array $inputs)
    {
        if ($this->verifyAccount($inputs))
        {
            $accessToken = auth()->user()->createToken('access_token')->plainTextToken;
            return response(['accessToken' => $accessToken]);
        }

        throw new AuthenticationException('Invalid username or password.');
    }

    public function logout (string $options)
    {
        if ($options != '')
        {
            auth()->user()->tokens()->delete();
        }
        else
        {
            auth()->user()->currentAccessToken()->delete();
        }
    }

    public function verifyAccount (array $inputs) : bool
    {
        return auth()->attempt(['email' => $inputs['email'], 'password' => $inputs['password']]);
    }
}