<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function handle()
    {
        try {
            auth()->user()->tokens()->delete();
            return ResponseHelper::success(message: "Logout success");
        } catch (\Exception $e) {
            return ResponseHelper::error(message: "Logout error");
        }
    }
}
