<?php
namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function listAllUser()
    {
        return $this->authRepository->listAllUser();
    }

    public function listUserVerify()
    {
        return $this->authRepository->listUserVerify();
    }

    public function register(array $data)
    {
        return $this->authRepository->create($data);
    }

    public function login(array $credentials)
    {
        $user = $this->authRepository->findByEmail($credentials['email']);

        if (!$user || !auth()->attempt($credentials)) {
            return false;
        }

        $customClaims = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];

        return JWTAuth::claims($customClaims)->fromUser($user);
    }

    public function verifyAccess($id)
    {
        return $this->authRepository->verifyAccess($id); 
    }

    public function getUser()
    {
        return auth()->user();
    }

    public function logout()
    {
        auth()->logout();
    }

    public function refresh()
    {
        return auth()->refresh();
    }

    public function delete($id)
    {
        return $this->authRepository->delete($id);
    }
}
