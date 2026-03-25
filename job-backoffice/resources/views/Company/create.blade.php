<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Company') }}
        </h2>
    </x-slot>
    <x-toast-notification />

    <div class="overflow-x-auto relative shadow-md sm:rounded-lg p-4 bg-gray-100">
        @if($errors->any())
            <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('Company.store') }}">
            @csrf
            <!-- Company Details -->
            <h3 class="text-lg font-semibold mb-4">Company Details</h3>
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Company Name:</label>
                <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="address" class="block text-gray-700 font-bold mb-2">Address:</label>
                <input type="text" id="address" name="address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="industry" class="block text-gray-700 font-bold mb-2">Industry:</label>
                <select id="industry" name="industry" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    @foreach($industries as $industry)
                        <option value="{{ $industry }}">{{ $industry }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="website" class="block text-gray-700 font-bold mb-2">Website: (Optional)</label>
                <input type="url" id="website" name="website" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            

            <!-- Owner Details -->
            <h3 class="text-lg font-semibold mb-4 mt-6">Company Owner Details</h3>
            <div class="mb-4">
                <label for="owner_name" class="block text-gray-700 font-bold mb-2">Owner Name:</label>
                <input type="text" id="owner_name" name="owner_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="owner_email" class="block text-gray-700 font-bold mb-2">Owner Email:</label>
                <input type="email" id="owner_email" name="owner_email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="owner_password" class="block text-gray-700 font-bold mb-2">Owner Password:</label>
                <input type="password" id="owner_password" name="owner_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none dark:focus:ring-blue-800">Create Company</button>
                <a href="{{ route('Company.index') }}" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">Cancel</a>
            </div>

        </form>
    </div>
</x-app-layout>
                  
