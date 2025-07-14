<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
            {{ __('Profile') }}
        </h2>
            <a href="{{ route('dashboard') }}" class="inline-block px-5 py-2 text-white rounded-lg shadow-lg transition ml-4 d-flex align-items-center"
               style="background: linear-gradient(90deg, #232526 0%, #414345 100%); font-weight: 600; letter-spacing: 0.5px; border: none;">
                <i class="bi bi-arrow-left me-2"></i> Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <!-- Change Avatar Form -->
                    <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" class="mb-6">
                        @csrf
                        <div class="flex items-center gap-4">
                            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'User') . '&background=2575fc&color=fff' }}" class="rounded-full" width="64" height="64" alt="Avatar">
                            <input type="file" name="avatar" accept="image/*" class="block">
                            <button type="submit" class="px-3 py-2 bg-gray-700 text-white rounded hover:bg-gray-900 transition">Change Avatar</button>
                        </div>
                    </form>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    
</x-app-layout>
