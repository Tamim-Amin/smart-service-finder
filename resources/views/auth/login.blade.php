<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart Local Service Finder</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-4 py-10 sm:py-12">
        <div class="w-full max-w-xl md:max-w-6xl grid grid-cols-1 md:grid-cols-2 bg-white rounded-2xl shadow-2xl overflow-hidden">

            <!-- Left Side - Brand/Image Section (md+) -->
            <div class="hidden md:flex flex-col justify-center items-center bg-gradient-to-br from-indigo-600 to-purple-700 p-8 lg:p-12 text-white">
                <div class="text-center max-w-sm">
                    <!-- Logo -->
                    <div class="mb-8">
                        <svg class="w-20 h-20 lg:w-24 lg:h-24 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>

                    <h1 class="text-3xl lg:text-4xl font-bold mb-4">Welcome Back!</h1>
                    <p class="text-base lg:text-lg text-indigo-100 mb-8">
                        Connect with trusted local service providers in your area
                    </p>

                    <!-- Features -->
                    <div class="space-y-4 text-left text-sm lg:text-base">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Verified professionals</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Real-time chat support</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Secure payments</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Transparent ratings & reviews</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="p-6 sm:p-8 lg:p-12">
                <div class="max-w-md mx-auto">
                    <!-- Mobile Logo -->
                    <div class="md:hidden text-center mb-8">
                        <svg class="w-14 h-14 mx-auto mb-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <h2 class="text-2xl font-bold text-gray-800">Welcome Back!</h2>
                        <p class="text-gray-600 mt-1 text-sm">Login to continue</p>
                    </div>

                    <div class="hidden md:block mb-8">
                        <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-2">Login</h2>
                        <p class="text-gray-600">Enter your credentials to access your account</p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Errors -->
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5 sm:space-y-6">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                    placeholder="you@example.com">
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input id="password" type="password" name="password" required
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-700">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition duration-200 font-semibold shadow-lg hover:shadow-xl transform md:hover:-translate-y-0.5">
                            Sign In
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="mt-8 mb-6">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white text-gray-500">Don't have an account?</span>
                            </div>
                        </div>
                    </div>

                    <!-- Register Link -->
                    <a href="{{ route('register') }}"
                       class="block w-full text-center bg-white border-2 border-indigo-600 text-indigo-600 py-3 rounded-lg hover:bg-indigo-50 transition duration-200 font-semibold">
                        Create Account
                    </a>
                </div>
            </div>

        </div>
    </div>
</body>
</html>