<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Smart Local Service Finder</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-purple-100 via-pink-50 to-indigo-100 min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-4 py-10 sm:py-12">
        <div class="w-full max-w-xl md:max-w-6xl grid grid-cols-1 md:grid-cols-2 bg-white rounded-2xl shadow-2xl overflow-hidden">

            <!-- Left Side - Registration Form -->
            <div class="p-6 sm:p-8 lg:p-12 order-2 md:order-1">
                <div class="max-w-md mx-auto">
                    <!-- Mobile Logo -->
                    <div class="md:hidden text-center mb-8">
                        <svg class="w-14 h-14 mx-auto mb-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <h2 class="text-2xl font-bold text-gray-800">Create Account</h2>
                        <p class="text-gray-600 mt-1 text-sm">Join as customer or provider</p>
                    </div>

                    <div class="hidden md:block mb-8">
                        <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-2">Create Account</h2>
                        <p class="text-gray-600">Join our community of trusted service providers</p>
                    </div>

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

                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                                    placeholder="John Doe">
                            </div>
                        </div>

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
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
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
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirm Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <!-- Role Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Register As
                            </label>

                            <!-- responsive: stack on xs, 2 columns from sm -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <label class="relative flex flex-col items-center justify-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-purple-500 transition group">
                                    <input type="radio" name="role" value="customer" {{ old('role') == 'customer' ? 'checked' : 'checked' }} class="sr-only peer" required>
                                    <svg class="w-8 h-8 text-gray-400 group-hover:text-purple-500 peer-checked:text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span class="text-sm font-semibold text-gray-700 peer-checked:text-purple-600">Customer</span>
                                    <span class="text-xs text-gray-500 mt-1">Find services</span>
                                    <div class="absolute inset-0 border-2 border-purple-600 rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                                </label>

                                <label class="relative flex flex-col items-center justify-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-purple-500 transition group">
                                    <input type="radio" name="role" value="provider" {{ old('role') == 'provider' ? 'checked' : '' }} class="sr-only peer" required>
                                    <svg class="w-8 h-8 text-gray-400 group-hover:text-purple-500 peer-checked:text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm font-semibold text-gray-700 peer-checked:text-purple-600">Provider</span>
                                    <span class="text-xs text-gray-500 mt-1">Offer services</span>
                                    <div class="absolute inset-0 border-2 border-purple-600 rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 rounded-lg hover:from-purple-700 hover:to-pink-700 transition duration-200 font-semibold shadow-lg hover:shadow-xl transform md:hover:-translate-y-0.5">
                            Create Account
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="mt-6 mb-4">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white text-gray-500">Already have an account?</span>
                            </div>
                        </div>
                    </div>

                    <!-- Login Link -->
                    <a href="{{ route('login') }}"
                       class="block w-full text-center bg-white border-2 border-purple-600 text-purple-600 py-3 rounded-lg hover:bg-purple-50 transition duration-200 font-semibold">
                        Sign In
                    </a>
                </div>
            </div>

            <!-- Right Side - Brand/Image Section (md+) -->
            <div class="hidden md:flex flex-col justify-center items-center bg-gradient-to-br from-purple-600 to-pink-700 p-8 lg:p-12 text-white order-1 md:order-2">
                <div class="text-center max-w-sm">
                    <!-- Logo -->
                    <div class="mb-8">
                        <svg class="w-20 h-20 lg:w-24 lg:h-24 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>

                    <h1 class="text-3xl lg:text-4xl font-bold mb-4">Join Our Community</h1>
                    <p class="text-base lg:text-lg text-purple-100 mb-8">
                        Start your journey as a customer or service provider today
                    </p>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-6 mt-10 text-sm lg:text-base">
                        <div class="text-center">
                            <div class="text-2xl lg:text-3xl font-bold mb-1">1200+</div>
                            <div class="text-purple-200">Active Users</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl lg:text-3xl font-bold mb-1">500+</div>
                            <div class="text-purple-200">Service Providers</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl lg:text-3xl font-bold mb-1">10+</div>
                            <div class="text-purple-200">Service Categories</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl lg:text-3xl font-bold mb-1">4.8★</div>
                            <div class="text-purple-200">Average Rating</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>