<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;

class ApiAuthController extends Controller
{
    //public function __construct()
    //{
    //    $this->middleware('auth:sanctum');
    //}

    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);//return response()->json(['test' => []]);
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        return response()->json([ 'api_token' => $user->createToken('api_token')->plainTextToken]);
    }
}
