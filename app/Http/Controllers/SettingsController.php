<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $settings_noauth = [
            'register' => config('app.register')
        ];

        $settings_auth = $settings_noauth + [

        ];

        if (Auth::check()) {
            return [ 'data' => $settings_auth ];
        } else {
            return [ 'data' => $settings_noauth ];
        }
    }
}
