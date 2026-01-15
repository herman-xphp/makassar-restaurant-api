<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Makassar Restaurant</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex bg-white">
        <!-- Left Side - Image/Brand -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gray-900">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop" 
                     alt="Background" 
                     class="w-full h-full object-cover opacity-50">
            </div>
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-900/90 to-teal-900/80"></div>
            <div class="relative z-10 w-full flex flex-col justify-center px-12 text-white">
                <div class="mb-8">
                    <x-application-logo class="w-16 h-16 text-emerald-400" />
                </div>
                <h1 class="text-5xl font-bold mb-6 leading-tight">Selamat Datang<br>di Dashboard</h1>
                <p class="text-emerald-100 text-lg max-w-md">
                    Kelola data restoran, menu, dan ulasan pengguna dalam satu platform terintegrasi.
                </p>
                <div class="mt-12 flex items-center space-x-4">
                    <div class="flex -space-x-2">
                        <div class="w-10 h-10 rounded-full border-2 border-emerald-900 bg-gray-300"></div>
                        <div class="w-10 h-10 rounded-full border-2 border-emerald-900 bg-gray-400"></div>
                        <div class="w-10 h-10 rounded-full border-2 border-emerald-900 bg-gray-500"></div>
                    </div>
                    <span class="text-sm font-medium text-emerald-200">Bergabung dengan admin lainnya</span>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50">
            <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">Masuk Akun</h2>
                    <p class="text-gray-500 mt-2">Silakan masuk untuk mengakses panel admin</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email Address')" class="text-gray-700" />
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <x-text-input id="email" class="block w-full pl-10 border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@example.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <x-text-input id="password" class="block w-full pl-10 border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg"
                                            type="password"
                                            name="password"
                                            required autocomplete="current-password"
                                            placeholder="••••••••" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500 transition cursor-pointer" name="remember">
                            <span class="ms-2 text-sm text-gray-600 group-hover:text-emerald-600 transition">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-emerald-600 hover:text-emerald-700 font-medium hover:underline" href="{{ route('password.request') }}">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transform transition hover:-translate-y-0.5 hover:shadow-lg">
                        {{ __('Log in securely') }}
                    </button>
                    
                    <div class="text-center mt-6">
                        <a href="/" class="text-sm text-gray-500 hover:text-emerald-600 font-medium transition flex items-center justify-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke Beranda
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
