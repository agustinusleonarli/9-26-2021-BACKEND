<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller

{
    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
            // 'mahasiswa_id' => $id[0]->id

        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'message' => 'Succes, Silahkan Pergi Ke Menu Login',
            'user' => $user,
            // 'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            // return response([
            //     'message' => 'Invalid Credentials, Recheck Email and Password'
            // ], 401);
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'message' => 'succes',
            'token' => $token,
            'expiration' => 1,
            'user' => $user,
            //'expiration' => 60 * 24 * 7,
            
        ];

        return response($response, 201);
    }
    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'succes'
        ];
    }
}
