<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Monamur - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <section class="flex loginSection" style="height: 100vh;">
        <div class="w-1/2">
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <div class="relative py-3 sm:mx-auto px-5">
                <div class="relative p-8 card py-10 h-full bg-white mx-8 shadow rounded-3xl sm:p-10">
                    <div class="max-w-md mx-auto">
                        <div class="items-center space-x-5 justify-center">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('images/favicon-monamur.png') }}" class="mx-auto" width="70" alt="monamur">
                            </a>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mt-5">
                                <label class="font-semibold text-sm text-gray-600 pb-1 block" for="login">E-mail</label>
                                <input class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" type="email" name="email" id="email" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                <label class="font-semibold text-sm text-gray-600 pb-1 block" for="password">Password</label>
                                <input class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" type="password" name="password" id="password" required autocomplete="current-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            @if (Route::has('password.request'))
                            <div class="text-right mb-4">
                                <a class="text-xs font-display font-semibold text-gray-500 hover:text-gray-600 cursor-pointer" href="{{ route('password.request') }}">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            </div>
                            @endif
                            <div class="mt-5">
                                <button type="submit" class="py-2 px-4 bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 focus:ring-offset-blue-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg">
                                    Iniciar Sesion
                                </button>
                            </div>
                        </form>
                        <div class="flex items-center justify-between mt-4">
                            <span class="w-1/5 border-b dark:border-gray-600 md:w-1/4"></span>
                            <a class="text-xs text-gray-500 uppercase dark:text-gray-400 hover:underline" href="{{ route('register') }}">o Registrate</a>
                            <span class="w-1/5 border-b dark:border-gray-400 md:w-1/4"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-1/2 bannerLogin">
           
        </div>
    </section>
</body>
</html>