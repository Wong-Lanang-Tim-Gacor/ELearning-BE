<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function handle(Request $request)
    {
        try{
            $user = User::query()->where('username', $request->username)->firstOrFail();
            if($user && Hash::check($request->password, $user->password)) {
                $user['token'] = $user->createToken($request->username)->plainTextToken;
                return ResponseHelper::success($user);
            } else{
                return ResponseHelper::error("Username atau password salah");
            }
        }catch (\Exception $e){
            return ResponseHelper::error($e->getMessage());
        }
    }
}
