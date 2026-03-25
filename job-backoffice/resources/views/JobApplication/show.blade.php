<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ ($jobApplication->user?->name ?? 'N/A') . ' Applied to ' . ($jobApplication->jobVacancy?->title ?? 'N/A') }}
            </h2>

        </div>
    </x-slot>

    <x-toast-notification />

    @php
        $resume = $jobApplication->resume;

        $hasResumeData =
            $resume &&
            (!empty($resume->summary) ||
                !empty($resume->skills) ||
                !empty($resume->experience) ||
                !empty($resume->education));

        $hasAi = !is_null($jobApplication->aiGeneratedScore) || !empty($jobApplication->aiGeneratedFeedback);

        $score = $jobApplication->aiGeneratedScore;

        if (is_numeric($score)) {
            $score = (float) $score;

            if ($score >= 80) {
                $badgeClass = 'bg-green-100 text-green-800';
                $barClass = 'bg-green-500';
                $label = 'Excellent Match';
            } elseif ($score >= 60) {
                $badgeClass = 'bg-yellow-100 text-yellow-800';
                $barClass = 'bg-yellow-500';
                $label = 'Good Match';
            } elseif ($score >= 40) {
                $badgeClass = 'bg-orange-100 text-orange-800';
                $barClass = 'bg-orange-500';
                $label = 'Average Match';
            } else {
                $badgeClass = 'bg-red-100 text-red-800';
                $barClass = 'bg-red-500';
                $label = 'Low Match';
            }
        }

        $statusClass = match ($jobApplication->status) {
            'Accepted' => 'bg-green-100 text-green-800 border border-green-200',
            'Rejected' => 'bg-red-100 text-red-800 border border-red-200',
            'Pending' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
            default => 'bg-gray-100 text-gray-700 border border-gray-200',
        };
        $experiences = json_decode($resume->experience, true);
    @endphp

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6 mb-10 space-y-6">

        <!-- Hero / Main Info -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
            <div class="p-6 lg:p-8">
                <div class="flex flex-col xl:flex-row xl:items-start xl:justify-between gap-8">
                    <div class="flex-1">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center">
                                <svg class="w-7 h-7 text-blue-700" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zM19 21H5a2 2 0 01-2-2v-1a7 7 0 0114 0v1a2 2 0 01-2 2z" />
                                </svg>
                            </div>

                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">
                                    Applicant Details
                                </h3>
                                <p class="text-sm text-gray-500">
                                    Quick overview of applicant, job, company, and status
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                                <div class="flex items-center gap-3 mb-2">
                                    <div
                                        class="w-9 h-9 rounded-xl bg-white border border-gray-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M16 14a4 4 0 10-8 0m8 0a4 4 0 01-8 0m8 0v1a2 2 0 002 2h1m-11-3v1a2 2 0 01-2 2H5" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-500">Applicant Name</p>
                                </div>
                                <p class="text-gray-900 font-medium">
                                    {{ $jobApplication->user?->name ?? 'N/A' }}
                                </p>
                            </div>

                            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                                <div class="flex items-center gap-3 mb-2">
                                    <div
                                        class="w-9 h-9 rounded-xl bg-white border border-gray-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-500">Job Vacancy</p>
                                </div>
                                <p class="text-gray-900 font-medium">
                                    {{ $jobApplication->jobVacancy?->title ?? 'N/A' }}
                                </p>
                            </div>

                            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                                <div class="flex items-center gap-3 mb-2">
                                    <div
                                        class="w-9 h-9 rounded-xl bg-white border border-gray-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-500">Location</p>
                                </div>
                                <p class="text-gray-900 font-medium">
                                    {{ $jobApplication->jobVacancy?->location ?? 'N/A' }}
                                </p>
                            </div>

                            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                                <div class="flex items-center gap-3 mb-2">
                                    <div
                                        class="w-9 h-9 rounded-xl bg-white border border-gray-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M3 21h18M5 21V7l7-4 7 4v14M9 9h.01M9 13h.01M9 17h.01M15 9h.01M15 13h.01M15 17h.01" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-500">Company</p>
                                </div>
                                <p class="text-gray-900 font-medium">
                                    {{ $jobApplication->jobVacancy?->company?->name ?? ($jobApplication->jobVacancy?->company ?? 'N/A') }}
                                </p>
                            </div>

                            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4">
                                <div class="flex items-center gap-3 mb-2">
                                    <div
                                        class="w-9 h-9 rounded-xl bg-white border border-gray-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-500">Status</p>
                                </div>
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold {{ $statusClass }}">
                                    {{ $jobApplication->status ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="xl:w-[250px]">
                        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5">
                            <div class="flex items-center gap-3 mb-4">
                                <div
                                    class="w-10 h-10 rounded-xl bg-white border border-blue-100 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M7 7V3m10 4V3m-11 8h12m-13 9h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Actions</h4>
                                    <p class="text-xs text-gray-500">Quick access</p>
                                </div>
                            </div>

                            @if ($jobApplication->resume)
                                <a href="{{ asset('storage/' . $jobApplication->resume->fileUrl) }}" target="_blank"
                                    class="inline-flex items-center justify-center w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-3 focus:outline-none">
                                    View Resume
                                </a>
                            @else
                                <div
                                    class="w-full text-center bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-500">
                                    Resume not available
                                </div>
                            @endif

                            <a href="{{ route('JobApplication.index') }}"
                                class="mt-3 inline-flex items-center justify-center w-full text-gray-700 bg-white border border-gray-200 hover:bg-gray-100 font-medium rounded-xl text-sm px-5 py-3">
                                Back to Applications
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
            <div class="p-6 lg:p-8">
                <nav class="flex items-center gap-3 border-b border-gray-200 pb-4">
                    <a href="{{ route('JobApplication.show', [$jobApplication->id, 'tab' => 'resume']) }}"
                        class="px-4 py-2 rounded-xl text-sm font-medium transition {{ request('tab', 'resume') == 'resume' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        Resume
                    </a>

                    <a href="{{ route('JobApplication.show', [$jobApplication->id, 'tab' => 'AiFeedback']) }}"
                        class="px-4 py-2 rounded-xl text-sm font-medium transition {{ request('tab') == 'AiFeedback' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        AI Feedback
                    </a>
                </nav>

                <!-- Resume Tab -->
                <div class="{{ request('tab', 'resume') == 'resume' ? 'block' : 'hidden' }} mt-6">
                    @if ($hasResumeData)
                        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

                            <!-- Summary -->
                            <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-indigo-700" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-semibold text-gray-800">Summary</h3>
                                </div>
                                <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                                    {{ $resume->summary ?: 'N/A' }}
                                </p>
                            </div>

                            <!-- Skills -->
                            <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.868v4.264a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-semibold text-gray-800">Skills</h3>
                                </div>
                                <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                                    {{ $resume->skills ?: 'N/A' }}
                                </p>
                            </div>

                            <!-- Experience Timeline -->
                            <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm xl:col-span-2">
                                <div class="flex items-center gap-3 mb-5">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M12 8v4l3 3M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-semibold text-gray-800">Experience</h3>
                                </div>

                                @if (is_array($experiences))
                                    <div class="space-y-4">
                                        @foreach ($experiences as $exp)
                                            <div class="border-l-4 border-blue-500 pl-4">
                                                <p class="font-semibold text-gray-800">
                                                    {{ $exp['title'] ?? '' }} - {{ $exp['company'] ?? '' }}
                                                </p>

                                                <p class="text-sm text-gray-500">
                                                    {{ $exp['start_date'] ?? '' }} - {{ $exp['end_date'] ?? '' }}
                                                    | {{ $exp['location'] ?? '' }}
                                                </p>

                                                @if (!empty($exp['highlights']))
                                                    <ul class="list-disc pl-5 mt-2 text-sm text-gray-700">
                                                        @foreach ($exp['highlights'] as $point)
                                                            <li>{{ $point }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif

                                                @if (!empty($exp['tech']))
                                                    <div class="mt-2 flex flex-wrap gap-2">
                                                        @foreach ($exp['tech'] as $tech)
                                                            <span class="px-2 py-1 text-xs bg-gray-100 rounded">
                                                                {{ $tech }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p>{{ $resume->experience }}</p>
                                @endif
                            </div>

                            <!-- Education Timeline -->
                            <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm xl:col-span-2">
                                <div class="flex items-center gap-3 mb-5">
                                    <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-purple-700" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 21c-2.331 0-4.507-.66-6.16-1.422L12 14z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-semibold text-gray-800">Education</h3>
                                </div>

                                @php
                                    $education = json_decode($resume->education, true);
                                @endphp

                                @if (is_array($education))
                                    <div class="space-y-4">
                                        @foreach ($education as $edu)
                                            <div class="border-l-4 border-purple-500 pl-4">
                                                <p class="font-semibold text-gray-800">
                                                    {{ $edu['degree'] ?? '' }}
                                                </p>

                                                <p class="text-sm text-gray-500">
                                                    {{ $edu['institution'] ?? '' }}
                                                </p>

                                                <p class="text-sm text-gray-500">
                                                    {{ $edu['start_date'] ?? '' }} - {{ $edu['end_date'] ?? '' }}
                                                </p>

                                                @if (!empty($edu['details']))
                                                    <p class="text-sm text-gray-700 mt-1">
                                                        {{ $edu['details'] }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p>{{ $resume->education }}</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="border border-dashed border-gray-300 rounded-2xl p-10 text-center">
                            <div
                                class="w-14 h-14 mx-auto rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </div>
                            <p class="text-gray-500">No resume data found.</p>
                        </div>
                    @endif
                </div>

                <!-- AI Feedback Tab -->
                <div class="{{ request('tab') == 'AiFeedback' ? 'block' : 'hidden' }} mt-6">
                    @if ($hasAi)
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                            <!-- AI Score -->
                            <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-orange-700" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.067 3.284a1 1 0 00.95.69h3.454c.969 0 1.371 1.24.588 1.81l-2.794 2.03a1 1 0 00-.364 1.118l1.067 3.284c.3.921-.755 1.688-1.538 1.118l-2.794-2.03a1 1 0 00-1.176 0l-2.794 2.03c-.783.57-1.838-.197-1.539-1.118l1.068-3.284a1 1 0 00-.364-1.118L2.98 8.71c-.783-.57-.38-1.81.588-1.81h3.454a1 1 0 00.95-.69l1.077-3.284z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-semibold text-gray-800">AI Score</h3>
                                </div>

                                @if (is_numeric($jobApplication->aiGeneratedScore))
                                    <div class="flex items-center gap-3 mb-4">
                                        <span class="px-3 py-1.5 text-sm font-bold rounded-full {{ $badgeClass }}">
                                            {{ number_format($score, 0) }}%
                                        </span>
                                        <span class="text-sm text-gray-500">{{ $label }}</span>
                                    </div>

                                    <div class="w-full bg-gray-200 rounded-full h-3 mb-3">
                                        <div class="{{ $barClass }} h-3 rounded-full transition-all duration-300"
                                            style="width: {{ min(max($score, 0), 100) }}%;">
                                        </div>
                                    </div>

                                    <p class="text-sm text-gray-500 leading-relaxed">
                                        This score reflects the overall match between the applicant profile and job
                                        requirements.
                                    </p>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-500">
                                        N/A
                                    </span>
                                @endif
                            </div>

                            <!-- AI Feedback -->
                            <div
                                class="lg:col-span-2 bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 rounded-2xl p-5">
                                <div class="flex items-center justify-between mb-5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-white border border-blue-100 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4v-4z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-base font-semibold text-gray-800">AI Feedback</h3>
                                            <p class="text-xs text-gray-500">Generated evaluation summary</p>
                                        </div>
                                    </div>

                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        AI Analysis
                                    </span>
                                </div>

                                <div class="bg-white/80 border border-white rounded-2xl p-5">
                                    <p class="text-sm text-gray-700 leading-7 whitespace-pre-line">
                                        {{ $jobApplication->aiGeneratedFeedback ?? 'No AI feedback found.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="border border-dashed border-gray-300 rounded-2xl p-10 text-center">
                            <div
                                class="w-14 h-14 mx-auto rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4-.8L3 20l1.2-3.2A7.657 7.657 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <p class="text-gray-500">No AI feedback found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
