<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Earnings Summary') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Filter Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('provider.earnings') }}" class="flex flex-wrap gap-4 items-end">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Period</label>
                            <select name="period" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                onchange="this.form.submit()">
                                <option value="all" {{ $period == 'all' ? 'selected' : '' }}>All Time</option>
                                <option value="today" {{ $period == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="week" {{ $period == 'week' ? 'selected' : '' }}>This Week</option>
                                <option value="month" {{ $period == 'month' ? 'selected' : '' }}>This Month</option>
                                <option value="year" {{ $period == 'year' ? 'selected' : '' }}>This Year</option>
                            </select>
                        </div>

                        @if($period == 'month')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Month</label>
                            <select name="month" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                onchange="this.form.submit()">
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Year</label>
                            <select name="year" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                onchange="this.form.submit()">
                                @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
                <div class="bg-gradient-to-br from-green-500 to-green-600 overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 text-white">
                        <p class="text-sm opacity-90 mb-1">Total Lifetime</p>
                        <p class="text-3xl font-bold">৳{{ number_format($stats['total_earnings'], 0) }}</p>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-500 to-blue-600 overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 text-white">
                        <p class="text-sm opacity-90 mb-1">Period Earnings</p>
                        <p class="text-3xl font-bold">৳{{ number_format($stats['period_earnings'], 0) }}</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-1">Total Hours</p>
                        <p class="text-3xl font-bold text-indigo-600">{{ number_format($stats['total_hours']) }}</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-1">Completed Jobs</p>
                        <p class="text-3xl font-bold text-purple-600">{{ $stats['total_jobs'] }}</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-1">Avg per Job</p>
                        <p class="text-3xl font-bold text-orange-600">৳{{ number_format($stats['average_per_job'], 0) }}</p>
                    </div>
                </div>
            </div>

            <!-- Monthly Breakdown Chart -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-6">Monthly Breakdown - {{ $year }}</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Month</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Earnings</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Hours</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jobs</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Visual</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($monthlyData as $data)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $data['month_name'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-green-600">
                                            ৳{{ number_format($data['total'], 0) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">
                                            {{ $data['hours'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">
                                            {{ $data['jobs'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($data['total'] > 0)
                                                @php
                                                    $maxEarning = max(array_column($monthlyData, 'total'));
                                                    $percentage = $maxEarning > 0 ? ($data['total'] / $maxEarning) * 100 : 0;
                                                @endphp
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-xs">No earnings</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Detailed Earnings List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-6">Earnings History</h3>

                    @forelse($earnings as $booking)
                        <div class="border border-gray-200 rounded-lg p-4 mb-4 hover:shadow-md transition">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <h4 class="text-lg font-semibold">{{ $booking->customer->name }}</h4>
                                        <span class="ml-3 bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                            Completed
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 space-y-1">
                                        <p><strong>Service Date:</strong> {{ $booking->service_date->format('M d, Y') }}</p>
                                        <p><strong>Completed:</strong> {{ $booking->updated_at->format('M d, Y h:i A') }}</p>
                                        <p><strong>Problem:</strong> {{ Str::limit($booking->problem_description, 100) }}</p>
                                        <p><strong>Duration:</strong> {{ $booking->total_hours }} hour(s) @ ৳{{ number_format($provider->hourly_rate, 0) }}/hr</p>
                                    </div>
                                </div>

                                <div class="ml-4 text-right">
                                    <div class="text-3xl font-bold text-green-600 mb-1">
                                        ৳{{ number_format($booking->total_amount, 0) }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $booking->updated_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-gray-500 mt-2">No earnings for this period</p>
                            <p class="text-sm text-gray-400 mt-1">Complete bookings to start earning</p>
                        </div>
                    @endforelse

                    @if($earnings->count() > 0)
                        <div class="mt-6">
                            {{ $earnings->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>