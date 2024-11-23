<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function handle(RegisterRequest $request)
    {
        try{
            $saveUser = User::create($request->validated());
            $saveUser['token'] = $saveUser->createToken($request->username)->plainTextToken;
            return ResponseHelper::success($saveUser, message: "Register success");
        }catch (\Exception $e){
            return ResponseHelper::error($e->getMessage(), message: "Register error");
        }
    }
}
