<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected function store(Request $request)
    {
        try {
            return $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            response($user)->json(['message' => 'Criado com successo'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Não foi possível criar o usuário', 'erro' => $e->getMessage()], 400);
        }
    }
}
