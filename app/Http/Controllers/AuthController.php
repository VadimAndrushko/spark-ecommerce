<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Login Page
    public function loginShow()
    {
        return view('auth.login');
    }

    // Login Store
    public function loginStore(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('success', 'Вы вошли в аккаунт!');
        }

        return back()->withErrors([
            'email' => 'Email или пароль неправильные.'
        ])->onlyInput('email');
    }

    // Register Page
    public function registerShow()
    {
        return view('auth.register');
    }

    // Register Store
    public function registerStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:8|confirmed',
            'terms' => 'required|accepted'
        ]);

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'password' => Hash::make($validated['password']),
                'role' => 'customer',
                'is_active' => true
            ]);

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('home')->with('success', 'Аккаунт создан успешно! Добро пожаловать!');
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при создании аккаунта. Попробуйте снова.')->withInput();
        }
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Вы вышли из аккаунта.');
    }
}
