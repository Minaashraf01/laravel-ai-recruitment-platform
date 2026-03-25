<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Company') }}: {{ $company->name }}
        </h2>
    </x-slot>
    @if(auth()->user()->role === 'company_owner')
    <div class="right-4 mb-4 mt-8">
                    <a href="{{ route('my-company.show') }}" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">Back</a>
    </div>
    @endif
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

        <!-- Form for Admin -->
    @if(auth()->user()->role === 'admin')
        <form method="POST" action="{{ route('Company.update', $company->id) }}">
            @csrf
            @method('PUT')
            <!-- Company Details -->
            <h3 class="text-lg font-semibold mb-4">Company Details</h3>
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Company Name:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $company->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="address" class="block text-gray-700 font-bold mb-2">Address:</label>
                <input type="text" id="address" name="address" value="{{ old('address', $company->address) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="industry" class="block text-gray-700 font-bold mb-2">Industry:</label>
                <select id="industry" name="industry" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    @foreach($industries as $industry)
                        <option value="{{ $industry }}" {{ (old('industry', $company->industry) == $industry) ? 'selected' : '' }}>{{ $industry }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="website" class="block text-gray-700 font-bold mb-2">Website: (Optional)</label>
                <input type="url" id="website" name="website" value="{{ old('website', $company->website) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <!-- Owner Details -->
            <h3 class="text-lg font-semibold mb-4 mt-6">Company Owner Details</h3>
            <div class="mb-4">
                <label for="owner_name" class="block text-gray-700 font-bold mb-2">Owner Name:</label>
                <input type="text" id="owner_name" name="owner_name" value="{{ old('owner_name', $company->owner->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <!-- Read only cannot be changed-->
            <div class="mb-4">
                <label for="owner_email" class="block text-gray-700 font-bold mb-2">Owner Email:(Read-only)</label>
                <input disabled type="email" id="owner_email" name="owner_email" value="{{ old('owner_email', $company->owner->email) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
            </div>
            <div class="mb-4">
                <label for="owner_password" class="block text-gray-700 font-bold mb-2">Owner Password: (Leave blank to keep current password)</label>
                <input type="password" id="owner_password" name="owner_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
                        <div class="flex items-center justify-between">
                <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">Update Company</button>
            </div>
        </form>
            <!-- Form for Company Owner -->
            @elseif(auth()->user()->role === 'company_owner' && auth()->user()->id === $company->ownerid)
                <form method="POST" action="{{ route('my-company.update', $company->id) }}">
                @csrf
            @method('PUT')
            <!-- Company Details -->
            <h3 class="text-lg font-semibold mb-4">Company Details</h3>
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Company Name:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $company->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="address" class="block text-gray-700 font-bold mb-2">Address:</label>
                <input type="text" id="address" name="address" value="{{ old('address', $company->address) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="industry" class="block text-gray-700 font-bold mb-2">Industry:</label>
                <select id="industry" name="industry" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    @foreach($industries as $industry)
                        <option value="{{ $industry }}" {{ (old('industry', $company->industry) == $industry) ? 'selected' : '' }}>{{ $industry }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="website" class="block text-gray-700 font-bold mb-2">Website: (Optional)</label>
                <input type="url" id="website" name="website" value="{{ old('website', $company->website) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <!-- Owner Details -->
            <h3 class="text-lg font-semibold mb-4 mt-6">Company Owner Details</h3>
            <div class="mb-4">
                <label for="owner_name" class="block text-gray-700 font-bold mb-2">Owner Name:</label>
                <input type="text" id="owner_name" name="owner_name" value="{{ old('owner_name', $company->owner->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <!-- Read only cannot be changed-->
            <div class="mb-4">
                <label for="owner_email" class="block text-gray-700 font-bold mb-2">Owner Email:(Read-only)</label>
                <input disabled type="email" id="owner_email" name="owner_email" value="{{ old('owner_email', $company->owner->email) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
            </div>
            <div class="mb-4">
                <label for="owner_password" class="block text-gray-700 font-bold mb-2">Owner Password:</label>
                <input type="password" id="owner_password" name="owner_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
                        <div class="flex items-center justify-between">
                <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">Update Company</button>
            </div>
        </form>
        @endif

    </div>
</x-app-layout>
          