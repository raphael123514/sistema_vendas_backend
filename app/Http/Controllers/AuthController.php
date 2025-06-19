<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\AuthResource;
use App\Actions\Auth\LoginAction;

class AuthController extends Controller
{
    public function __construct(private LoginAction $loginAction) {}

    public function login(LoginRequest $request)
    {
        $result = $this->loginAction->execute($request->email, $request->password);
        
        if (! $result) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }
        return new AuthResource($result);
    }
}
