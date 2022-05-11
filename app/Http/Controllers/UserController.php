<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Contracts\UserServiceContract;

class UserController extends Controller
{
    private UserServiceContract $userService;

    /**
     * @param UserServiceContract $userService
     */
    public function __construct (UserServiceContract $userService)
    {
        $this->userService = $userService;
    }

    public function readManyProductCarts (Request $request, string $userId)
    {
        return $this->userService->readManyProductCarts($userId);
    }
}
