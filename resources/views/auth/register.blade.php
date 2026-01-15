@extends('layouts.app')

@section('content')
<div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    
    <div class="mb-6">
        <a href="/">
            <x-application-logo />
        </a>
    </div>

    <div class="w-full max-w-md bg-white shadow-md overflow-hidden sm:rounded-lg px-6 py-4">
        
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-input-label for="name" value="Nombre Completo" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="email" value="Correo Electrónico" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" value="Contraseña" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password_confirmation" value="Confirmar Contraseña" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    ¿Ya registrado?
                </a>

                <x-primary-button class="ms-4 bg-red-600 hover:bg-red-700">
                    Registrarse
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection