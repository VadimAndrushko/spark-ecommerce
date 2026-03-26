@extends('layouts.app')

@section('title', 'Реєстрація | Spark')

@section('content')
    <div class="max-w-2xl mx-auto py-12">
        <div class="bg-white shadow-lg rounded-lg p-8 border border-gray-200">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold">⚡ SPARK</h1>
                <p class="text-gray-600 mt-2">Створіть новий аккаунт</p>
            </div>

            <!-- Form -->
            <form action="{{ route('register.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf

                <!-- Full Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-semibold mb-2">Ім'я та Прізвище *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('name') border-red-500 @enderror"
                        placeholder="Іван Петренко" required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="md:col-span-2">
                    <label for="email" class="block text-sm font-semibold mb-2">Email Адреса *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('email') border-red-500 @enderror"
                        placeholder="your@email.com" required>
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="md:col-span-2">
                    <label for="phone" class="block text-sm font-semibold mb-2">Номер телефону</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        placeholder="+380 XX XXX XXXX">
                    @error('phone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold mb-2">Пароль *</label>
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('password') border-red-500 @enderror"
                        placeholder="Мин. 8 символів" required>
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Пароль має містити: букви, цифри, спеціальні символи</p>
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold mb-2">Підтвердження Пароля *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('password_confirmation') border-red-500 @enderror"
                        placeholder="Повторіть пароль" required>
                    @error('password_confirmation')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Terms & Conditions -->
                <div class="md:col-span-2">
                    <div class="flex items-start gap-3">
                        <input type="checkbox" id="terms" name="terms" class="w-4 h-4 mt-1 accent-yellow-500" required>
                        <label for="terms" class="text-sm text-gray-700">
                            Я погоджуюсь з 
                            <a href="#" class="text-yellow-500 hover:underline">умовами використання</a> та
                            <a href="#" class="text-yellow-500 hover:underline">політикою приватності</a>
                        </label>
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="md:col-span-2">
                    <div class="flex items-start gap-3">
                        <input type="checkbox" id="newsletter" name="newsletter" class="w-4 h-4 mt-1 accent-yellow-500" checked>
                        <label for="newsletter" class="text-sm text-gray-700">
                            Надсилайте мені новини про акції та знижки
                        </label>
                    </div>
                </div>

                <!-- Submit -->
                <div class="md:col-span-2">
                    <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 rounded-lg transition">
                        ✓ Створити Аккаунт
                    </button>
                </div>
            </form>

            <!-- Divider -->
            <div class="flex items-center gap-4 my-8">
                <div class="flex-1 h-px bg-gray-300"></div>
                <span class="text-gray-500 text-sm">Або</span>
                <div class="flex-1 h-px bg-gray-300"></div>
            </div>

            <!-- Social Login -->
            <div class="space-y-3">
                <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-3 rounded-lg transition flex items-center justify-center gap-2">
                    <span>f</span> Зареєструватися через Facebook
                </button>
                <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-3 rounded-lg transition flex items-center justify-center gap-2">
                    <span>G</span> Зареєструватися через Google
                </button>
            </div>

            <!-- Login Link -->
            <p class="text-center mt-8 text-gray-700">
                Вже маєте аккаунт?
                <a href="{{ route('login.show') }}" class="text-yellow-500 font-bold hover:underline">Увійти</a>
            </p>

            <!-- Trust Badges -->
            <div class="mt-8 pt-6 border-t">
                <div class="grid grid-cols-3 gap-4 text-center text-sm text-gray-600">
                    <div>
                        <div class="text-2xl mb-1">🔒</div>
                        <p>Передача даних безпечна</p>
                    </div>
                    <div>
                        <div class="text-2xl mb-1">✓</div>
                        <p>Простої регістрація</p>
                    </div>
                    <div>
                        <div class="text-2xl mb-1">💬</div>
                        <p>Поддержка доступна</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
