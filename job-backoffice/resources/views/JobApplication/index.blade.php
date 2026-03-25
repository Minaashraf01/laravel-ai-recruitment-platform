<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        @if(auth()->user()->role == 'admin')
            {{ __('All Job Applications for Companines') }}
        @else
            {{ __('Job Applications') }}
        @endif
        </h2>
    </x-slot>

    <x-toast-notification />

    <!-- Archived toggle -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        <div class="flex justify-end">
            @if (request('archived') == 'true')
                <a href="{{ route('JobApplication.index') }}"
                    class="inline-flex items-center text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                    View Active Job Applications
                </a>
            @else
                <a href="{{ route('JobApplication.index', ['archived' => 'true']) }}"
                    class="inline-flex items-center text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                    View Archived Job Applications
                </a>
            @endif
        </div>
    </div>

    <!-- Table -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Applicant Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Position
                                    </th>

                                    @if (auth()->user()->role == 'admin')
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Company</th>
                                    @endif

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Score
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($jobApplications as $jobApplication)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <a href="{{ route('JobApplication.show', $jobApplication->id) }}"
                                                class="text-blue-600 hover:text-blue-800">
                                                {{ $jobApplication->user->name ?? 'N/A' }}
                                            </a>
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $jobApplication->jobVacancy->title ?? 'N/A' }}
                                        </td>

                                        @if (auth()->user()->role == 'admin')
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                {{ $jobApplication->jobVacancy->company ?? 'N/A' }}
                                            </td>
                                        @endif

                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $jobApplication->status }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $jobApplication->jobVacancy->type ?? 'N/A' }}
                                        </td>

                                        <!-- ✅ Improved Score UI -->
                                        <td class="px-6 py-4">
                                            @php
                                                $score = $jobApplication->aiGeneratedScore;

                                                if (is_numeric($score)) {
                                                    $score = (float) $score;

                                                    if ($score >= 80) {
                                                        $badgeClass = 'bg-green-100 text-green-800';
                                                        $barClass = 'bg-green-500';
                                                        $label = 'Excellent';
                                                    } elseif ($score >= 60) {
                                                        $badgeClass = 'bg-yellow-100 text-yellow-800';
                                                        $barClass = 'bg-yellow-500';
                                                        $label = 'Good';
                                                    } elseif ($score >= 40) {
                                                        $badgeClass = 'bg-orange-100 text-orange-800';
                                                        $barClass = 'bg-orange-500';
                                                        $label = 'Average';
                                                    } else {
                                                        $badgeClass = 'bg-red-100 text-red-800';
                                                        $barClass = 'bg-red-500';
                                                        $label = 'Low';
                                                    }
                                                }
                                            @endphp

                                            @if (is_numeric($jobApplication->aiGeneratedScore))
                                                <div class="min-w-[140px]">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <span
                                                            class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $badgeClass }}">
                                                            {{ number_format($score, 0) }}%
                                                        </span>
                                                        <span class="text-xs text-gray-500">{{ $label }}</span>
                                                    </div>

                                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                                        <div class="{{ $barClass }} h-2 rounded-full"
                                                            style="width: {{ min(max($score, 0), 100) }}%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span
                                                    class="px-2.5 py-1 text-xs bg-gray-100 text-gray-500 rounded-full">
                                                    N/A
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if (!$jobApplication->deleted_at)
                                                <a href="{{ route('JobApplication.edit', $jobApplication->id) }}"
                                                    class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-yellow-600 dark:hover:bg-yellow-700 focus:outline-none dark:focus:ring-yellow-800">
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('JobApplication.destroy', $jobApplication->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">
                                                        Archive
                                                    </button>
                                                </form>
                                            @else
                                                <form
                                                    action="{{ route('JobApplication.restore', $jobApplication->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-blue-500 hover:text-blue-700">
                                                        Restore
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <!-- ✅ fixed colspan -->
                                        <td colspan="{{ auth()->user()->role == 'admin' ? 7 : 6 }}"
                                            class="py-4 px-6 text-center text-gray-500">
                                            No Job Applications Found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $jobApplications->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
