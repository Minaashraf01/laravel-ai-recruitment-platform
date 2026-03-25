<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ $company->name }}
            </h2>
            <p class="text-sm text-gray-500">
                Company profile, jobs, and applications overview
            </p>
        </div>
    </x-slot>

    <x-toast-notification />

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6 mb-10 space-y-6">

        @php
            $statusClass = fn($status) => match($status) {
                'Accepted' => 'bg-green-100 text-green-800 border border-green-200',
                'Rejected' => 'bg-red-100 text-red-800 border border-red-200',
                'Pending' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                default => 'bg-gray-100 text-gray-700 border border-gray-200',
            };
        @endphp

        <!-- Company Info -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
            <div class="p-6 lg:p-8">
                <div class="flex flex-col xl:flex-row xl:items-start xl:justify-between gap-8">
                    <div class="flex-1">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center">
                                <svg class="w-7 h-7 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 21h18M5 21V7l7-4 7 4v14M9 9h.01M9 13h.01M9 17h.01M15 9h.01M15 13h.01M15 17h.01"/>
                                </svg>
                            </div>

                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">Company Information</h3>
                                <p class="text-sm text-gray-500">Overview of company details and owner information</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                                <p class="text-sm font-medium text-gray-500 mb-1">Owner</p>
                                <p class="text-gray-900 font-medium">{{ $company->owner->name ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                                <p class="text-sm font-medium text-gray-500 mb-1">Email</p>
                                <p class="text-gray-900 font-medium">{{ $company->owner->email ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                                <p class="text-sm font-medium text-gray-500 mb-1">Address</p>
                                <p class="text-gray-900 font-medium">{{ $company->address ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                                <p class="text-sm font-medium text-gray-500 mb-1">Industry</p>
                                <p class="text-gray-900 font-medium">{{ $company->industry ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4 md:col-span-2">
                                <p class="text-sm font-medium text-gray-500 mb-1">Website</p>
                                @if($company->website)
                                    <a href="{{ $company->website }}"
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-800 hover:underline break-all font-medium">
                                        {{ $company->website }}
                                    </a>
                                @else
                                    <p class="text-gray-900 font-medium">N/A</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="xl:w-[280px]">
                        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5">
                            <h4 class="font-semibold text-gray-800 mb-4">Actions</h4>

                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('Company.index') }}"
                                   class="inline-flex items-center justify-center w-full text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-xl text-sm px-5 py-3 mb-3 focus:outline-none">
                                    Back to Companies
                                </a>

                                <a href="{{ route('Company.edit', $company->id) }}"
                                   class="inline-flex items-center justify-center w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-3 mb-3 focus:outline-none">
                                    Edit Company
                                </a>

                                <form action="{{ route('Company.destroy', $company->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center justify-center w-full text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-xl text-sm px-5 py-3 focus:outline-none"
                                            onclick="return confirm('Are you sure you want to archive this company?');">
                                        Archive Company
                                    </button>
                                </form>
                            @endif

                            @if(auth()->user()->role === 'company_owner' && auth()->user()->id === $company->ownerid)
                                <a href="{{ route('my-company.edit', $company->id) }}"
                                   class="inline-flex items-center justify-center w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-3 focus:outline-none">
                                    Edit
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->role === 'admin')
            <!-- Tabs -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-6 lg:p-8">
                    <nav class="flex items-center gap-3 border-b border-gray-200 pb-4">
                        <a href="{{ route('Company.show', ['Company' => $company->id, 'tab' => 'jobs']) }}"
                           class="px-4 py-2 rounded-xl text-sm font-medium transition {{ request('tab', 'jobs') == 'jobs' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                            Jobs
                        </a>

                        <a href="{{ route('Company.show', ['Company' => $company->id, 'tab' => 'applications']) }}"
                           class="px-4 py-2 rounded-xl text-sm font-medium transition {{ request('tab') == 'applications' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                            Applications
                        </a>
                    </nav>

                    <!-- Jobs Tab -->
                    <div class="{{ request('tab', 'jobs') == 'jobs' ? 'block' : 'hidden' }} mt-6">
                        <div class="overflow-x-auto rounded-2xl border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200 bg-white">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Job Title
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Location
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Type
                                        </th>

                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-100">
                                    @forelse($company->jobVacancies as $job)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                                {{ $job->title }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                {{ $job->location }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                                    {{ $job->type }}
                                                </span>
                                            </td>
     
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">
                                                No jobs found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Applications Tab -->
                    <div class="{{ request('tab') == 'applications' ? 'block' : 'hidden' }} mt-6">
                        <div class="overflow-x-auto rounded-2xl border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200 bg-white">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Applicant Name
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Job Title
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-100">
                                    @forelse($company->jobApplications as $application)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                                {{ $application->user->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                {{ $application->jobVacancy->title ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass($application->status) }}">
                                                    {{ $application->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                <a href="{{ route('JobApplication.show', $application->id) }}"
                                                   class="text-blue-600 hover:text-blue-800 font-medium hover:underline">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">
                                                No applications found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        @endif

    </div>
</x-app-layout>