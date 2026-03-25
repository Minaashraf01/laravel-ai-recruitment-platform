<x-guest-layout>

    <div class="w-full max-w-md mx-auto">

        <!-- Admin Title -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Admin Panel 3ayenni
            </h1>


        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" value="Email" />

                <x-text-input
                    id="email"
                    class="block mt-1 w-full"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Enter email"
                />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="relative" x-data="{ show: false }">

                <x-input-label for="password" value="Password" />

                <div class="relative">
                    <x-text-input
                        id="password"
                        class="block mt-1 w-full pr-10"
                        x-bind:type="show ? 'text' : 'password'"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Enter password"
                    />

                    <!-- Show / Hide Password -->
                    <button
                        type="button"
                        class="absolute inset-y-0 right-2 flex items-center text-gray-400 hover:text-gray-600"
                        @click="show = !show"
                    >

                        <!-- Eye -->
                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5
                                c4.478 0 8.268 2.943 9.542 7
                                -1.274 4.057-5.064 7-9.542 7
                                -4.478 0-8.268-2.943-9.542-7z"/>
                        </svg>

                        <!-- Eye Off -->
                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A9.56 9.56 0 0112 19
                                c-4.478 0-8.268-2.943-9.542-7
                                1.002-3.364 3.843-6 7.542-7.575"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3l18 18"/>
                        </svg>

                    </button>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        name="remember">

                    <span class="ms-2 text-sm text-gray-600">
                        Remember me
                    </span>
                </label>
            </div>

            <!-- Login Button -->
            <div>
                <x-primary-button class="w-full justify-center">
                    Login 
                </x-primary-button>
            </div>

        </form>

    </div>

</x-guest-layout>