<?php
namespace App\Repositories;

use App\Models\User;

class AuthRepository
{
    public function create(array $data)
    {
        return User::create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }
}
