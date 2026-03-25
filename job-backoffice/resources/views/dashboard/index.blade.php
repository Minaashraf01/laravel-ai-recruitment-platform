<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Dashboard for') }}  {{ auth()->user()->role == 'admin' ? 'Admin' : 'Company-Owner' }}
            </h2>
            <p class="text-sm text-gray-500">
                {{ __('Welcome') }}, {{ auth()->user()->name }}
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Overview Section -->
            <div>
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Overview</h3>
                    <p class="text-sm text-gray-500">Quick insights about platform activity and performance.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Active Users -->
                    <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Active Users</p>
                                <h3 class="text-3xl font-bold text-indigo-600 mt-2">
                                    {{ $analytics['activeUsers'] ?? 0 }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-2">Last 30 days</p>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5V4H2v16h5m10 0v-2a4 4 0 00-4-4H11a4 4 0 00-4 4v2m10 0H7m10-10a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Jobs -->
                    <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Jobs</p>
                                <h3 class="text-3xl font-bold text-blue-600 mt-2">
                                    {{ $analytics['totalJobs'] ?? 0 }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-2">All time published jobs</p>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2H10a2 2 0 00-2 2v2m8 0H8m8 0h3a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h3"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Applications -->
                    <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Applications</p>
                                <h3 class="text-3xl font-bold text-emerald-600 mt-2">
                                    {{ $analytics['totalApplications'] ?? 0 }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-2">All submitted applications</p>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Most Applied Jobs -->
            <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">Most Applied Jobs</h3>
                    <p class="text-sm text-gray-500 mt-1">Jobs with the highest number of applications.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Job Title
                                </th>
                                @if(auth()->user()->role == 'admin')
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Company
                                    </th>
                                @endif
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Total Applications
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse(($analytics['mostappliedJobs'] ?? []) as $job)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                        {{ $job->title }}
                                    </td>

                                    @if(auth()->user()->role == 'admin')
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $job->company }}
                                        </td>
                                    @endif

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-700">
                                            {{ $job->TotalApplications }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->role == 'admin' ? 3 : 2 }}"
                                        class="px-6 py-8 text-center text-sm text-gray-500">
                                        No application data found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Conversion Rates -->
            <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">Conversion Rates</h3>
                    <p class="text-sm text-gray-500 mt-1">Compare job views with submitted applications.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Job Title
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Views
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Applications
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Conversion Rate
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse(($analytics['conversionRate'] ?? []) as $rate)
                                @php
                                    $views = $rate['viewCount'] ?? 0;
                                    $applications = $rate['TotalApplications'] ?? 0;
                                    $conversion = $views > 0 ? (($applications / $views) * 100) : null;

                                    if (!is_null($conversion)) {
                                        if ($conversion >= 20) {
                                            $badgeClass = 'bg-green-100 text-green-800';
                                            $barClass = 'bg-green-500';
                                        } elseif ($conversion >= 10) {
                                            $badgeClass = 'bg-yellow-100 text-yellow-800';
                                            $barClass = 'bg-yellow-500';
                                        } else {
                                            $badgeClass = 'bg-red-100 text-red-800';
                                            $barClass = 'bg-red-500';
                                        }
                                    }
                                @endphp

                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                        {{ $rate['job_title'] }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $views }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $applications }}
                                    </td>

                                    <td class="px-6 py-4 min-w-[220px]">
                                        @if(!is_null($conversion))
                                            <div class="space-y-2">
                                                <div class="flex items-center justify-between gap-3">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                                        {{ number_format($conversion, 2) }}%
                                                    </span>
                                                </div>

                                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                    <div class="{{ $barClass }} h-2.5 rounded-full"
                                                         style="width: {{ min($conversion, 100) }}%;">
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                                N/A
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">
                                        No conversion data found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>