<?php
namespace App\Repositories;

use App\Models\User;

class AuthRepository
{
    public function listAllUser()
    {
        try {
            $data = User::get();
            return $data;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function listUserVerify()
    {
        try {
            $data = User::where('status', '0')->get();
            return $data;
        } catch (\Exception $e) {
            return false;
        }
    }


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

    public function verifyAccess($id)
    {
        $dataUser = User::find($id);
    
        if ($dataUser) {
            $dataUser->update(['status' => '2']);
            return true;
        }
    
        return false;
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return true;
        }
        return false;
    }
    
}
