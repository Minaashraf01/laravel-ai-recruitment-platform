<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Job Vacancy')  }}
        </h2>
    </x-slot>
    <x-toast-notification />
    <!-- Create Job Vacancy Form -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('JobVacancy.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    </div>
                    
                    <!-- Company Name Input for Admins -->
                    @if(auth()->user()->role == 'admin')
                    <div class="mb-4">
                        <label for="company" class="block text-gray-700 font-medium mb-2">Company</label>
                        <input type="text" name="company" id="company" value="{{ old('company') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                    @error('company')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    </div>
                    @endif

                    <!-- Location Input -->
                    <div class="mb-4">
                        <label for="location" class="block text-gray-700 font-medium mb-2">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                    @error('location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    </div>
                    <div class="mb-4">
                        <label for="salary" class="block text-gray-700 font-medium mb-2">Expected Salary (USD)</label>
                        <input type="number" name="salary" id="salary" value="{{ old('salary') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                    @error('salary')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    </div>
                    <div class="mb-4">
                        <label for="type" class="block text-gray-700 font-medium mb-2">Type</label>
                        <select name="type" id="type" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            <option value="full-time"{{ old('type') == 'full-time' ? ' selected' : '' }}>full-time</option>
                            <option value="Remote"{{ old('type') == 'Remote' ? ' selected' : '' }}>Remote</option>
                            <option value="contract"{{ old('type') == 'contract' ? ' selected' : '' }}>contract</option>
                            <option value="Hybrid"{{ old('type') == 'Hybrid' ? ' selected' : '' }}>Hybrid</option>
                        </select>
                    @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    </div> 
                    @if(auth()->user()->role == 'admin')
                    <!-- Company Select-->
                    <div class="mb-4">
                        <label for="company_id" class="block text-gray-700 font-medium mb-2">Company</label>
                        <select name="company_id" id="company_id" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}"{{ old('company_id') == $company->id ? ' selected' : '' }}>{{ $company->name }}</option>
                            @endforeach
                        </select>
                        @error('company_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                        @else
                        <div class="mb-4">
                            <label for="company" class="block text-gray-700 font-medium mb-2">Company</label>
                            <input type="text" name="company" id="company" value="{{ $company->name }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" disabled>
                        </div>
                        <input type="hidden" name="company_id" value="{{ $company->id }}">
                    @endif  
                    <!-- JobCategory Select-->
                    <div class="mb-4">
                        <label for="job_category_id" class="block text-gray-700 font-medium mb-2">Job Category</label>
                        <select name="job_category_id" id="job_category_id" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            @foreach($jobCategories as $jobCategory)
                                <option value="{{ $jobCategory->id }}"{{ old('job_category_id') == $jobCategory->id ? ' selected' : '' }}>{{ $jobCategory->name }}</option>
                            @endforeach
                        </select>
                        @error('job_category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                        <textarea name="description" id="description" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Create Job Vacancy</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
