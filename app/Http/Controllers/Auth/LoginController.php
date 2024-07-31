<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __invoke()
    {
        $data = request()->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        if (!auth()->attempt($data)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        request()->session()->regenerate();

        return response()->noContent();
    }
}
