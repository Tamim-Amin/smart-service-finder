<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl md:text-3xl text-gray-800 leading-tight">
            {{ __('Manage Providers') }}
        </h2>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-4 rounded-lg mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Header with Icon -->
            <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 mb-8 border-l-4 border-green-600">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-1">All Service Providers</h3>
                        <p class="text-gray-600">Manage, verify, and monitor service providers</p>
                    </div>
                    <svg class="w-12 h-12 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-4 md:px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Provider</th>
                                <th class="px-4 md:px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider hidden md:table-cell">Category</th>
                                <th class="px-4 md:px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider hidden lg:table-cell">Location</th>
                                <th class="px-4 md:px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Rate</th>
                                <th class="px-4 md:px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider hidden sm:table-cell">Rating</th>
                                <th class="px-4 md:px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider hidden md:table-cell">Earnings</th>
                                <th class="px-4 md:px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-4 md:px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($providers as $provider)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-4 md:px-6 py-4">
                                        <div class="flex items-center min-w-0">
                                            <img src="{{ $provider->user->profile_photo_url }}" 
                                                 alt="{{ $provider->user->name }}" 
                                                 class="w-10 h-10 rounded-full object-cover border-2 border-gray-300 mr-3 flex-shrink-0">
                                            <div class="min-w-0">
                                                <div class="text-sm font-semibold text-gray-900 truncate">{{ $provider->user->name }}</div>
                                                <div class="text-xs text-gray-500 truncate">{{ $provider->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 md:px-6 py-4 text-sm text-gray-900 hidden md:table-cell">
                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded-md text-xs font-semibold">{{ $provider->category->name }}</span>
                                    </td>
                                    <td class="px-4 md:px-6 py-4 text-sm text-gray-600 hidden lg:table-cell">
                                        {{ $provider->location }}
                                    </td>
                                    <td class="px-4 md:px-6 py-4 text-sm font-bold text-gray-900">
                                        ৳{{ number_format($provider->hourly_rate, 0) }}/hr
                                    </td>
                                    <td class="px-4 md:px-6 py-4 text-sm hidden sm:table-cell">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-yellow-400 fill-current mr-1" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                            <span class="font-semibold text-gray-800">{{ number_format($provider->average_rating, 1) }}</span>
                                            <span class="text-gray-500 text-xs ml-1">({{ $provider->total_reviews }})</span>
                                        </div>
                                    </td>
                                    <td class="px-4 md:px-6 py-4 text-sm font-bold text-green-600 hidden md:table-cell">
                                        ৳{{ number_format($provider->total_earnings ?? 0, 0) }}
                                    </td>
                                    <td class="px-4 md:px-6 py-4">
                                        @if($provider->is_verified)
                                            <span class="px-3 inline-flex text-xs leading-6 font-bold rounded-full bg-green-100 text-green-800 border border-green-300">
                                                ✓ Verified
                                            </span>
                                        @else
                                            <span class="px-3 inline-flex text-xs leading-6 font-bold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-300">
                                                ⏳ Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 md:px-6 py-4 text-sm font-medium">
                                        <form action="{{ route('admin.providers.verify', $provider->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" 
                                                class="px-3 py-2 rounded transition
                                                    {{ $provider->is_verified ? 'text-orange-600 hover:bg-orange-50' : 'text-green-600 hover:bg-green-50' }}">
                                                {{ $provider->is_verified ? 'Unverify' : 'Verify' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-gray-500 text-sm">No providers found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($providers->count() > 0)
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        {{ $providers->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>