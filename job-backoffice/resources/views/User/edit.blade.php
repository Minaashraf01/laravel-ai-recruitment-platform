<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User (Password Only)') }}
        </h2>
    </x-slot>
    <x-toast-notification />

    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 mt-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="mb-4 rounded bg-red-100 p-3 text-red-700">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- User Info (Read-only) --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">User Information</h3>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Name</label>
                        <input type="text"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-100"
                               value="{{ $user->name }}"
                               readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Email</label>
                        <input type="text"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-100"
                               value="{{ $user->email }}"
                               readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Role</label>
                        <input type="text"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-100"
                               value="{{ $user->role }}"
                               readonly>
                    </div>
                </div>

                {{-- Password Update Form --}}
                <form method="POST" action="{{ route('User.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <h3 class="text-lg font-semibold mb-4">Change Password</h3>

                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 font-bold mb-2">New Password</label>
                        <input type="password"
                               id="password"
                               name="password"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               required>
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Confirm New Password</label>
                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               required>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            Save Password
                        </button>

                        <a href="{{ route('User.index') }}"
                           class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
