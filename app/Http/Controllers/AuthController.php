<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Http\Controllers\EmailController;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function listAllUser()
    {
        $result = $this->authService->listAllUser();
        if ($result) {
            return response()->json(['message' => 'berhasil', 'data' => $result], 200);   
        }
        return response()->json(['message' => 'gagal'], 401);      
    }

    public function listUserVerify()
    {
        $result = $this->authService->listUserVerify();
        if ($result) {
            return response()->json(['message' => 'berhasil', 'data' => $result], 200);   
        }
        return response()->json(['message' => 'gagal'], 401);   
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|email|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        $user = User::create([
            'nama' => $request->input('nama'),
            'email' => $request->input('email'),
        ]);

        if ($user) {
            // $this->emailController->index($user->id);
            Mail::to($user->email)->send(new SendEmail($user->id));
            // Mail::to($user->email)->send(new EmailVerification($user));
            return response()->json(['message' => 'Registration successful', 'id' => $user->id],201);
        } else {
            return response()->json(['message' => 'Registration failed'], 500);
        }
    }

    public function login(Request $request)
    {
        $user = User::where('email', request('email'))->first();
        if ($user->status === '0') {
            return response()->json(['error' => 'anda belum verifikasi akun!!']);
        }
        $credentials = $request->only('email', 'password');
        $token = $this->authService->login($credentials);

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function verifyAccess($id)
    {
        $result = $this->authService->verifyAccess($id);
        if ($result) {
            return response()->json(['message' => 'Verifikasi Akses berhasil'], 200);   
        }
        return response()->json(['message' => 'Verifikasi Akses gagal'], 401);   
    }

    public function me()
    {
        return response()->json($this->authService->getUser());
    }

    public function logout()
    {
        $this->authService->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        $token = $this->authService->refresh();

        return $this->respondWithToken($token);
    }

    public function delete($id)
    {
        $result = $this->authService->delete($id);
        if ($result) {
            return response()->json([
                'message' => 'berhasil delete user'
            ]);
        }
        return response()->json([
            'message' => 'gagal delete user'
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'sub' => auth()->user()->id,
            'nama' => auth()->user()->nama,
            'email' => auth()->user()->email,
            'level' => auth()->user()->level,
            'status' => auth()->user()->status,
            'iat' => now()->timestamp,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }
}




