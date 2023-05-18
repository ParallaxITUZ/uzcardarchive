<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
        <style>
            .auth-header {
                font-family: 'Roboto', sans-serif;
                font-style: normal;
                font-weight: 500;
                font-size: 30px;
                line-height: 35px;
                color: #31507D;
                text-align: center;
                margin-bottom: 16px;
            }

            .auth-p {
                font-family: 'Roboto', sans-serif;
                font-style: normal;
                font-weight: normal;
                font-size: 18px;
                line-height: 21px;
                color: #91A1B9;
                margin-bottom: 34px;
                text-align: center;
            }
        </style>

        <h2 class="auth-header">{{ __('auth.welcome') }}</h2>
        <p class="auth-p">{{ __('auth.enter') }}</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Login -->
            <div>
                <x-label for="login" :value="__('auth.login')" />

                <x-input id="login" class="block mt-1 w-full" type="text" name="login" :value="old('login')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('auth.Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('auth.remember_me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('auth.forgot_your_password?') }}
                    </a>
                @endif

                <x-button class="ml-3">
                    {{ __('auth.signin') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
