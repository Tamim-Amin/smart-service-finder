<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile Photo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-6">Update Profile Photo</h3>

                    <div class="mb-6 text-center">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"
                            class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-gray-200 shadow-lg"
                            id="preview-image">
                        <p class="text-sm text-gray-600 mt-2">Current Profile Photo</p>
                    </div>

                    <form id="photo-upload-form" action="{{ route('profile.photo.update') }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Choose New Photo
                            </label>
                            <input type="file" name="profile_photo" accept="image/*" required
                                onchange="previewImage(event)" class="block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-md file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-indigo-50 file:text-indigo-700
                                          hover:file:bg-indigo-100
                                          cursor-pointer">
                            <p class="text-xs text-gray-500 mt-2">
                                JPG, PNG, GIF up to 2MB
                            </p>
                        </div>
                    </form>
                    <div class="flex space-x-3 mt-6">
                        <button type="submit" form="photo-upload-form"
                            class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">
                            Upload Photo
                        </button>

                        @if(Auth::user()->profile_photo)
                            <form action="{{ route('profile.photo.destroy') }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to remove your profile photo?')"
                                    class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 transition">
                                    Remove Photo
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h4 class="text-lg font-semibold mb-4">Or Choose an Avatar</h4>
                        <p class="text-sm text-gray-600 mb-4">Click on an avatar to use it as your profile photo</p>

                        <div class="grid grid-cols-4 md:grid-cols-6 gap-4">
                            @php
                                $avatarStyles = ['adventurer', 'avataaars', 'bottts', 'fun-emoji', 'lorelei', 'micah', 'miniavs', 'pixel-art'];
                                $seed = Auth::user()->email;
                            @endphp
                            @foreach($avatarStyles as $style)
                                <div class="cursor-pointer hover:scale-110 transition"
                                    onclick="selectAvatar('{{ $style }}', '{{ $seed }}')">
                                    <img src="https://api.dicebear.com/7.x/{{ $style }}/svg?seed={{ $seed }}"
                                        alt="{{ $style }}"
                                        class="w-full rounded-lg border-2 border-gray-200 hover:border-indigo-500">
                                    <p class="text-xs text-center mt-1 text-gray-600">{{ ucfirst($style) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const preview = document.getElementById('preview-image');
                preview.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function selectAvatar(style, seed) {
            if (confirm('Use this avatar as your profile photo?')) {
                const avatarUrl = `https://api.dicebear.com/7.x/${style}/svg?seed=${seed}`;

                fetch(avatarUrl)
                    .then(response => response.blob())
                    .then(blob => {
                        const formData = new FormData();
                        formData.append('profile_photo', blob, 'avatar.png');
                        formData.append('_token', '{{ csrf_token() }}');

                        fetch('{{ route("profile.photo.update") }}', {
                            method: 'POST',
                            body: formData
                        })
                            .then(response => response.json())
                            .then(data => {
                                window.location.reload();
                            })
                            .catch(error => {
                                alert('Error uploading avatar. Please try uploading an image instead.');
                            });
                    });
            }
        }
    </script>
</x-app-layout>