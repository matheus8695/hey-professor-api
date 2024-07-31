<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

class RegisterController extends Controller
{
    public function __invoke()
    {
        $data = request()->validate([
            'name'     => ['required', 'min:3', 'max:255'],
            'email'    => ['required', 'min:3', 'max:255', 'email', 'unique:users', 'confirmed'],
            'password' => ['required', 'min:8', 'max:40'],
        ]);

        $user = User::create($data);

        auth()->login($user);
    }
}
