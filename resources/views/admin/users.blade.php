<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl md:text-3xl text-gray-800 leading-tight">
            {{ __('Manage Users') }}
        </h2>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div
                    class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-4 rounded-lg mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Header with Icon -->
            <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 mb-8 border-l-4 border-purple-600">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-1">All Users</h3>
                        <p class="text-gray-600">Manage and view all platform users</p>
                    </div>
                    <svg class="w-12 h-12 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th
                                    class="px-4 md:px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    User</th>
                                <th
                                    class="px-4 md:px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Email</th>
                                <th
                                    class="px-4 md:px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Role</th>
                                <th
                                    class="px-4 md:px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Joined</th>
                                <th
                                    class="px-4 md:px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-4 md:px-6 py-4">
                                        <div class="flex items-center">
                                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                                                class="w-10 h-10 rounded-full object-cover border-2 border-gray-300 mr-3">
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                                <div class="text-xs text-gray-500">ID: {{ substr($user->id, 0, 8) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 md:px-6 py-4 text-sm text-gray-600">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-4 md:px-6 py-4">
                                        @if($user->userRole)
                                                                    <span
                                                                        class="px-3 inline-flex text-xs leading-6 font-bold rounded-full 
                                                                                {{ $user->userRole->role == 'admin' ? 'bg-red-100 text-red-800 border border-red-300' :
                                            ($user->userRole->role == 'provider' ? 'bg-blue-100 text-blue-800 border border-blue-300' : 'bg-green-100 text-green-800 border border-green-300') }}">
                                                                        {{ ucfirst($user->userRole->role) }}
                                                                    </span>
                                        @endif
                                    </td>
                                    <td class="px-4 md:px-6 py-4 text-sm text-gray-600">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-4 md:px-6 py-4 text-sm font-medium">
                                        @if($user->id !== auth()->id())
                                            <button
                                                onclick="if(confirm('Are you sure you want to delete this user? This action cannot be undone.')) document.getElementById('delete-user-{{ $user->id }}').submit();"
                                                class="text-red-600 hover:text-red-900 hover:bg-red-50 px-3 py-2 rounded transition">
                                                Delete
                                            </button>
                                            <form id="delete-user-{{ $user->id }}"
                                                action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                                class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs font-semibold">You</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 6a3 3 0 11-6 0 3 3 0 016 0zM6 20a9 9 0 0118 0v-2a9 9 0 00-18 0v2z" />
                                        </svg>
                                        <p class="text-gray-500 text-sm">No users found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($users->count() > 0)
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>