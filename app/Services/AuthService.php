<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use Illuminate\Auth\AuthenticationException;
use App\Repositories\Contracts\UserRepositoryContract;

class AuthService implements Contracts\AuthServiceContract
{
    private UserRepositoryContract $userRepository;

    /**
     * @param UserRepositoryContract $userRepository
     */
    public function __construct (UserRepositoryContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register (array $inputs)
    {
        if (empty($errors = $this->_isEmailOrPhoneUsed($inputs)))
        {
            $this->_createUser($inputs);
            return response('', 201);
        }
        else
        {
            return response(['errors' => $errors], 406);
        }
    }

    private function _isEmailOrPhoneUsed (array $inputs) : array
    {
        $users = $this->_readUsersByEmailOrPhone(($inputs));
        if ($users->count() == 1)
        {
            if ($users[0]->email == $inputs['email'])
            {
                $message['email'] = 'This email is already taken';

            }

            if ($users[0]->phone == $inputs['phone'])
            {
                $message['phone'] = 'This phone is already taken';
            }

            return $message;
        }

        if ($users->count() == 2)
        {
            return [
                'email' => 'This email is already taken',
                'phone' => 'This phone is already taken'
            ];
        }

        return [];
    }

    private function _readUsersByEmailOrPhone (array $inputs)
    {
        return $this->userRepository->find(['email', 'phone'],
                                           [['email', '=', $inputs['email']],
                                            ['phone', '|=', $inputs['phone']]]);
    }

    private function _createUser (array $inputs)
    {
        $inputs['password'] = bcrypt($inputs['password']);
        $this->userRepository->insert($inputs);
    }

    /**
     * @throws AuthenticationException
     */
    public function login (array $inputs)
    {
        if ($this->verifyAccount($inputs))
        {
            $accessToken = auth()->user()->createToken('access_token')->plainTextToken;
            return response(['data'        => new UserResource(auth()->user()),
                             'accessToken' => $accessToken,]);
        }

        throw new AuthenticationException('Invalid email or password.');
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