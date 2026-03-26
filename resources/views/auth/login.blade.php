@extends('layouts.app')

@section('title', 'Вход в аккаунт | Spark')

@section('content')
    <div class="max-w-md mx-auto py-12">
        <div class="bg-white shadow-lg rounded-lg p-8 border border-gray-200">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold">⚡ SPARK</h1>
                <p class="text-gray-600 mt-2">Вход у вашу учетну запис</p>
            </div>

            <!-- Form -->
            <form action="{{ route('login.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold mb-2">Email Адреса *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('email') border-red-500 @enderror"
                        placeholder="your@email.com" required>
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold mb-2">Пароль *</label>
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('password') border-red-500 @enderror"
                        placeholder="Введите вашу пароль" required>
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 accent-yellow-500" checked>
                    <label for="remember" class="ml-2 text-sm text-gray-700">Запамятати мене</label>
                </div>

                <!-- Submit -->
                <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 rounded-lg transition">
                    ➜ Увійти
                </button>

                <!-- Forgot Password -->
                <div class="text-center">
                    <a href="#" class="text-yellow-500 hover:underline text-sm">Забули пароль?</a>
                </div>
            </form>

            <!-- Divider -->
            <div class="flex items-center gap-4 my-8">
                <div class="flex-1 h-px bg-gray-300"></div>
                <span class="text-gray-500 text-sm">Або</span>
                <div class="flex-1 h-px bg-gray-300"></div>
            </div>

            <!-- Social Login (Optional) -->
            <div class="space-y-3">
                <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-3 rounded-lg transition flex items-center justify-center gap-2">
                    <span>f</span> Вход через Facebook
                </button>
                <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-3 rounded-lg transition flex items-center justify-center gap-2">
                    <span>G</span> Вход через Google
                </button>
            </div>

            <!-- Register Link -->
            <p class="text-center mt-8 text-gray-700">
                Немаєте акаунту?
                <a href="{{ route('register.show') }}" class="text-yellow-500 font-bold hover:underline">Зареєструватися</a>
            </p>

            <!-- Trust Info -->
            <div class="mt-8 pt-6 border-t">
                <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                    <span>🔒</span>
                    <span>Ваши данные защищены</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <span>💬</span>
                    <span>Техподдержка доступна 24/7</span>
                </div>
            </div>
        </div>
    </div>
@endsection
