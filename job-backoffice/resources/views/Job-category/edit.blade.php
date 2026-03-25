<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            {{ __('Update Job Category') }}
        </h2>
    </x-slot>
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg p-4 bg-white">
        <form action="{{ route('Job-category.update', $jobCategory->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Category Name:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $jobCategory->name) }}" 
                class="{{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                @error('name')
                    <h4 class="text-red-500 font-bold text-xs italic mt-2">{{ $message }}</h4>
                @enderror
            </div>
            
            <div>
                <button type="submit" class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-yellow-600 dark:hover:bg-yellow-700 focus:outline-none dark:focus:ring-yellow-800">Update Category</button>
                <a href="{{ route('Job-category.index') }}" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">Cancel</a>
            </div>
        </form>
    </div>     
</x-app-layout> 