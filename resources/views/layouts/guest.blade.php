<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sylhet Sheba') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 relative overflow-hidden">
            
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-indigo-100 opacity-50 blur-3xl -z-10"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-purple-100 opacity-50 blur-3xl -z-10"></div>

            <div class="mb-6 z-10">
                <a href="/" class="flex flex-col items-center group">
                    <x-application-logo class="w-24 h-24 fill-current text-indigo-600 transition transform group-hover:scale-105" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-2 px-8 py-8 bg-white shadow-2xl sm:rounded-2xl border border-gray-100 relative z-10">
                {{ $slot }}
            </div>

            <p class="mt-8 text-center text-sm text-gray-500 z-10">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </body>
</html>