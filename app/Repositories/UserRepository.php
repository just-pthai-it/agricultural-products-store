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

        UserRepositoryContract::class    => UserRepository::class,

}