<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Abstracts\BaseRepository;

class UserRepository extends BaseRepository implements Contracts\UserRepositoryContract
{
    function model () : string
    {
        return User::class;
    }

    public function findProductCartsByUserId (string $userId)
    {
        $this->createModel();
        return $this->model->find($userId)->carts;
    }
}