<?php

namespace App\Http\Repositories;

use Illuminate\Http\Request;
use App\Models\User;

class UserRepository
{
    public static function findById($idUser)
    {
       return User::findOrFail($idUser);
    }

    public static function update($request, $user)
    {
        return $user->update($request);
    }
}
