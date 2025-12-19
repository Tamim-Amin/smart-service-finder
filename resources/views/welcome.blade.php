<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sylhet Sheba') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans text-gray-900 bg-white">

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center gap-2">
                        <x-application-logo class="h-10 w-auto fill-current text-indigo-600" />
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-700 hover:text-indigo-600">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-indigo-600">Log in</a>
                            <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-indigo-700 transition">Get Started</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="relative bg-gray-50 overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-indigo-100 opacity-50 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-purple-100 opacity-50 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24 relative">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-5xl font-extrabold text-gray-900 tracking-tight mb-6">
                    Welcome to <span class="text-indigo-600">Sylhet Sheba</span> <br> Expert Services, Locally.
                </h1>
                <p class="text-xl text-gray-600 mb-10">
                    From home repairs to beauty services, connect with trusted professionals in your neighborhood instantly. Verified reviews, secure bookings.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-indigo-600 text-white rounded-xl font-bold text-lg shadow-lg hover:bg-indigo-700 hover:scale-105 transition transform flex items-center justify-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Find a Service
                    </a>
                    
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-gray-800 border-2 border-gray-200 rounded-xl font-bold text-lg hover:border-indigo-600 hover:text-indigo-600 transition flex items-center justify-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Become a Provider
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900">How It Works</h2>
                <p class="mt-4 text-gray-600">Simple steps for everyone.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                <div class="bg-indigo-50 rounded-2xl p-8">
                    <h3 class="text-2xl font-bold text-indigo-900 mb-6 flex items-center gap-2">
                        <span class="bg-indigo-600 text-white p-2 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </span>
                        For Customers
                    </h3>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center font-bold text-indigo-600 shrink-0">1</div>
                            <div>
                                <h4 class="font-bold text-gray-900">Search & Compare</h4>
                                <p class="text-sm text-gray-600">Browse trusted professionals by category. Check ratings, prices, and reviews.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center font-bold text-indigo-600 shrink-0">2</div>
                            <div>
                                <h4 class="font-bold text-gray-900">Book Instantly</h4>
                                <p class="text-sm text-gray-600">Select a date and time that works for you. No phone calls needed.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center font-bold text-indigo-600 shrink-0">3</div>
                            <div>
                                <h4 class="font-bold text-gray-900">Relax & Rate</h4>
                                <p class="text-sm text-gray-600">Get the job done. Pay securely and leave a review to help others.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="bg-gray-800 text-white p-2 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        For Providers
                    </h3>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="w-8 h-8 bg-white border border-gray-200 rounded-full flex items-center justify-center font-bold text-gray-700 shrink-0">1</div>
                            <div>
                                <h4 class="font-bold text-gray-900">Create Profile</h4>
                                <p class="text-sm text-gray-600">Sign up as a provider. Add your skills, photos of your work, and set your hourly rate.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-8 h-8 bg-white border border-gray-200 rounded-full flex items-center justify-center font-bold text-gray-700 shrink-0">2</div>
                            <div>
                                <h4 class="font-bold text-gray-900">Get Hired</h4>
                                <p class="text-sm text-gray-600">Receive booking notifications from local customers directly on your dashboard.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-8 h-8 bg-white border border-gray-200 rounded-full flex items-center justify-center font-bold text-gray-700 shrink-0">3</div>
                            <div>
                                <h4 class="font-bold text-gray-900">Earn & Grow</h4>
                                <p class="text-sm text-gray-600">Complete jobs, build your reputation with 5-star reviews, and grow your business.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="py-20 bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold">Popular Services</h2>
                    <p class="mt-2 text-gray-400">Most requested services in your area.</p>
                </div>
                <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold flex items-center">
                    View All Categories <span class="ml-2">→</span>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-gray-800 p-6 rounded-xl hover:bg-gray-700 transition cursor-pointer group">
                    <span class="text-4xl mb-4 block group-hover:scale-110 transition">🧹</span>
                    <h3 class="font-bold text-lg">Home Cleaning</h3>
                    <p class="text-sm text-gray-400 mt-1">120+ Pros</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-xl hover:bg-gray-700 transition cursor-pointer group">
                    <span class="text-4xl mb-4 block group-hover:scale-110 transition">🔌</span>
                    <h3 class="font-bold text-lg">Electrician</h3>
                    <p class="text-sm text-gray-400 mt-1">85+ Pros</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-xl hover:bg-gray-700 transition cursor-pointer group">
                    <span class="text-4xl mb-4 block group-hover:scale-110 transition">🛁</span>
                    <h3 class="font-bold text-lg">Plumbing</h3>
                    <p class="text-sm text-gray-400 mt-1">90+ Pros</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-xl hover:bg-gray-700 transition cursor-pointer group">
                    <span class="text-4xl mb-4 block group-hover:scale-110 transition">👩🏻‍🏫</span>
                    <h3 class="font-bold text-lg">Tutor</h3>
                    <p class="text-sm text-gray-400 mt-1">60+ Pros</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-16 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-gray-100">
                <div>
                    <div class="text-4xl font-extrabold text-indigo-600">500+</div>
                    <div class="mt-2 text-sm font-medium text-gray-500 uppercase tracking-wider">Active Providers</div>
                </div>
                <div>
                    <div class="text-4xl font-extrabold text-indigo-600">1.2k</div>
                    <div class="mt-2 text-sm font-medium text-gray-500 uppercase tracking-wider">Happy Customers</div>
                </div>
                <div>
                    <div class="text-4xl font-extrabold text-indigo-600">5k+</div>
                    <div class="mt-2 text-sm font-medium text-gray-500 uppercase tracking-wider">Jobs Completed</div>
                </div>
                <div>
                    <div class="text-4xl font-extrabold text-indigo-600">4.8</div>
                    <div class="mt-2 text-sm font-medium text-gray-500 uppercase tracking-wider">Average Rating</div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <div class="flex items-center gap-2">
                        <x-application-logo class="h-8 w-auto fill-current text-gray-800" />
                    </div>
                    <p class="text-gray-500 text-sm mt-2">Connecting you with the best local professionals.</p>
                </div>
                
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-gray-500 transition">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                    </a>

                    <a href="#" class="text-gray-400 hover:text-gray-500 transition">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.468 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                    </a>

                    <a href="#" class="text-gray-400 hover:text-gray-500 transition">
                        <span class="sr-only">Twitter</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M13.6823 10.6218L20.2391 3H18.6854L12.9921 9.61788L8.44486 3H3.2002L10.0765 13.0074L3.2002 21H4.75404L10.7663 14.0113L15.5685 21H20.8131L13.6819 10.6218H13.6823ZM11.5541 13.0956L10.8574 12.0991L5.31391 4.16971H7.70053L12.1742 10.5689L12.8709 11.5655L18.6861 19.8835H16.2995L11.5541 13.096V13.0956Z"/></svg>
                    </a>
                </div>
            </div>
            
            <div class="mt-8 border-t border-gray-100 pt-8 text-center md:text-left">
                <p class="text-sm text-gray-400">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>