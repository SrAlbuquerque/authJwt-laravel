<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'store']]);
    }
    protected function store(Request $request)
    {
        try {
            //Setta as regras para passar na validação
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'password' => 'required|string|confirmed|min:4',
            ]);

            //Retorna um erro se não passar na validação
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Não passou na validação',
                    $validator->errors()->toJson()
                ], 400);
            }

            //Cria o usuário no DB
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            return response()->json([
                'message' => 'Usuário criado com sucesso',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Não foi possível criar o usuário', 'erro' => $e->getMessage()], 400);
        }
    }
}
