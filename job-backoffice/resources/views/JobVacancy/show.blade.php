<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Vacancy Details')  }}
        </h2>
    </x-slot>
    <x-toast-notification />
    <!-- Job Vacancy Details -->

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-2xl font-semibold mb-4">{{ $jobVacancy->title }}</h3>
                <p class="mb-2"><strong>Company:</strong> {{ $jobVacancy->company }}</p>
                <p class="mb-2"><strong>Location:</strong> {{ $jobVacancy->location }}</p>
                <p class="mb-2"><strong>Salary:</strong> {{ $jobVacancy->salary }}</p>
                <p class="mb-2"><strong>Type:</strong> {{ $jobVacancy->type }}</p>
                <p class="mb-4"><strong>Description:</strong> {{ $jobVacancy->description }}</p>
                <a href="{{ route('JobVacancy.index') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Back to Job Vacancies</a>
     </div>
        </div>
        <!-- Tabs for Details and Applications -->
        <div class="mt-6">
            <nav class="flex space-x-4 border-b border-gray-200">
               <a href="{{ route('JobVacancy.show', [$jobVacancy->id, 'tab' => 'applications']) }}">
                   <button class="px-3 py-2 font-medium text-gray-700 hover:text-gray-900 {{ request('tab') == 'applications' ? 'border-b-2 border-blue-500' : '' }}">
                       Applications
                   </button>
            </nav>
    <!-- Applications Tab -->
             <div class="{{ request('tab') == 'applications' ? 'block' : 'hidden'}} p-4 bg-white border border-t-0 rounded-b-lg mt-4">
            <table class="min-w-full bg-white border mt-4">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">Applicant Name</th>
                    <th class="px-4 py-2 border">Job Title</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobVacancy->jobApplications as $application)
                <tr>
                    <td class="px-4 py-2 border">{{ $application->user->name }}</td>
                    <td class="px-4 py-2 border">{{ $application->jobVacancy->title }}</td>
                    <td class="px-4 py-2 border">{{ $application->status }}</td>
                    <td class="px-4 py-2 border">
                        <a href="{{ route('JobApplication.show', $application->id) }}" class="text-blue-500 hover:underline">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-2 border text-center">No applications found.</td>
                </tr>
                @endforelse
            </tbody>

            
            </table>

        </div>


    </div>
</x-app-layout>