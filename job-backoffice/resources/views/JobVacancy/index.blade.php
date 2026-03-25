<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        @if(auth()->user()->role == 'admin')
            {{ __('All Job Vacancies for Companines') }}
        @else
            {{ __('Job Vacancies') }}
        @endif
        </h2>
    </x-slot>
    <x-toast-notification />
    <!-- Archived toggle (right aligned) -->
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
    <div class="flex justify-end">
        @if (request('archived') == 'true')
            <a href="{{ route('JobVacancy.index') }}"
               class="inline-flex items-center text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                View Active Job Vacancies
            </a>
        @else
            <a href="{{ route('JobVacancy.index', ['archived' => 'true']) }}"
               class="inline-flex items-center text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                View Archived Job Vacancies
            </a>
        @endif
    </div>
</div>
    <!-- ADD NEW JOB VACANCY BUTTON -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-2 mb-0">
        <a href="{{ route('JobVacancy.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Add New Job Vacancy</a>
    </div>
    <!-- Job Vacancies Table -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">title</th>
                                @if(auth()->user()->role == 'admin')
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                                @endif
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Salary</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
    @forelse($jobVacancies as $jobVacancy)
        <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            <a href="{{ route('JobVacancy.show', $jobVacancy->id) }}" class="text-blue-600 hover:text-blue-800">{{ $jobVacancy->title }}</a></td>
            @if(auth()->user()->role == 'admin')
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $jobVacancy->company }}</td>
            @endif
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $jobVacancy->location }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $jobVacancy->salary }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $jobVacancy->type }}</td>

            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                @if (!$jobVacancy->deleted_at)
                    <a href="{{ route('JobVacancy.edit', $jobVacancy->id) }}" class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-yellow-600 dark:hover:bg-yellow-700 focus:outline-none dark:focus:ring-yellow-800">Edit</a>
                    <form action="{{ route('JobVacancy.destroy', $jobVacancy->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">Archive</button>
                    </form>
                @else
                    <form action="{{ route('JobVacancy.restore', $jobVacancy->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-blue-500 hover:text-blue-700 ">Restore</button>
                    </form>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="py-4 px-6 text-center text-gray-500">
                No Job Vacancies Found.
            </td>
        </tr>
    @endforelse
</tbody>


                    </table>
                    <div class="mt-4">
                        {{ $jobVacancies->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    </x-app-layout>

