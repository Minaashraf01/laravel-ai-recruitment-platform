<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-2xl text-white leading-tight">
                    {{ __('My Job Applications') }}
                </h2>
                <p class="text-sm text-gray-300 mt-1">
                    {{ __('Track your applications, AI score, and feedback in a clear detailed view.') }}
                </p>
            </div>

            <span class="hidden sm:inline-flex items-center gap-2 text-sm text-gray-200 bg-white/10 border border-white/10 px-4 py-2 rounded-2xl">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                {{ $jobs->count() }} {{ __('Applications') }}
            </span>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-white/[0.05] border border-white/10 shadow-2xl shadow-black/30 overflow-hidden">
                <div class="h-1.5 bg-gradient-to-r from-indigo-500 via-fuchsia-500 to-violet-500"></div>

                <div class="p-6 sm:p-8">
                    @if(session('success'))
                        <div class="mb-8 rounded-2xl border border-emerald-500/30 bg-emerald-500/10 p-5 text-emerald-100">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 rounded-xl bg-emerald-500/20 border border-emerald-500/30 p-2">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold">{{ __('Success') }}</p>
                                    <p class="text-sm text-emerald-100/90 mt-1">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($jobs->isEmpty())
                        <div class="rounded-2xl border border-white/10 bg-black/20 p-10 text-center">
                            <div class="mx-auto w-14 h-14 rounded-2xl bg-white/10 border border-white/10 flex items-center justify-center">
                                <svg class="w-7 h-7 text-gray-200" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M8 7V6a4 4 0 0 1 8 0v1" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                    <path d="M6 7h12l1 13a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L6 7Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>

                            <p class="text-white font-semibold text-lg mt-4">
                                {{ __('No applications yet') }}
                            </p>
                            <p class="text-gray-400 mt-2">
                                {{ __('You have not applied to any jobs yet.') }}
                            </p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($jobs as $application)
                                @php
                                    $status = strtolower($application->status);
                                    $score = (int) ($application->aiGeneratedScore ?? 0);

                                    $statusStyles = match ($status) {
                                        'accepted' => 'bg-emerald-500/15 text-emerald-200 border-emerald-500/30',
                                        'rejected' => 'bg-red-500/15 text-red-200 border-red-500/30',
                                        'pending'  => 'bg-amber-500/15 text-amber-200 border-amber-500/30',
                                        default    => 'bg-white/10 text-gray-200 border-white/10',
                                    };

                                    $scoreBarClass = match (true) {
                                        $score >= 80 => 'from-emerald-500 to-green-400',
                                        $score >= 60 => 'from-indigo-500 to-violet-500',
                                        $score >= 40 => 'from-amber-500 to-yellow-400',
                                        $score > 0   => 'from-red-500 to-rose-400',
                                        default      => 'from-gray-500 to-gray-400',
                                    };
                                @endphp

                                <div class="rounded-3xl border border-white/10 bg-[#08152b]/90 shadow-lg shadow-black/25 overflow-hidden hover:border-white/20 transition">
                                    <div class="p-6 sm:p-7">
                                        <div class="flex flex-col xl:flex-row xl:items-start xl:justify-between gap-6">
                                            <div class="min-w-0 flex-1">
                                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                                                    <div class="min-w-0">
                                                        <h3 class="text-2xl font-semibold text-white leading-tight">
                                                            {{ $application->jobVacancy->title }}
                                                        </h3>

                                                        <div class="mt-2 space-y-1 text-sm text-gray-300">
                                                            @if(!empty($application->jobVacancy->company_name))
                                                                <p>{{ $application->jobVacancy->company_name }}</p>
                                                            @endif

                                                            @if(!empty($application->jobVacancy->location))
                                                                <p>{{ $application->jobVacancy->location }}</p>
                                                            @endif

                                                            <p>{{ $application->created_at->format('d M Y') }}</p>
                                                        </div>
                                                    </div>

                                                    @if(!empty($application->jobVacancy->type))
                                                        <span class="shrink-0 inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-md shadow-indigo-900/30">
                                                            {{ $application->jobVacancy->type }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="mt-5 flex flex-wrap items-center gap-3 text-sm">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $statusStyles }}">
                                                        <span class="capitalize">{{ $application->status }}</span>
                                                    </span>

                                                    @if($application->resume && $application->resume->fileUrl)
                                                        <div class="text-gray-300">
                                                            <span class="text-gray-400">{{ __('Applied With') }}:</span>
                                                            <span class="text-gray-200">{{ $application->resume->filename }}</span>
                                                            <a href="{{ $application->resume->fileUrl }}"
                                                               target="_blank"
                                                               class="ml-2 font-medium text-indigo-400 hover:text-indigo-300 transition">
                                                                {{ __('View Resume') }}
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="xl:w-72 shrink-0">
                                                <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-4">
                                                    <div class="flex items-center justify-between">
                                                        <p class="text-sm text-gray-300">{{ __('AI Match Score') }}</p>
                                                        <p class="text-xl font-bold text-white">{{ $score }}%</p>
                                                    </div>

                                                    <div class="mt-3 h-2.5 w-full rounded-full bg-white/10 overflow-hidden">
                                                        <div class="h-full rounded-full bg-gradient-to-r {{ $scoreBarClass }}"
                                                             style="width: {{ min(100, max(0, $score)) }}%">
                                                        </div>
                                                    </div>

                                                    <p class="mt-3 text-xs text-gray-400 leading-6">
                                                        @if($score >= 80)
                                                            {{ __('Excellent alignment with job requirements.') }}
                                                        @elseif($score >= 60)
                                                            {{ __('Good alignment with room for improvement.') }}
                                                        @elseif($score > 0)
                                                            {{ __('Partial match based on current resume analysis.') }}
                                                        @else
                                                            {{ __('AI analysis not available yet.') }}
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-6 rounded-2xl border border-white/10 bg-black/20 p-5">
                                            <div class="flex items-center gap-2 mb-3">
                                                <div class="w-8 h-8 rounded-lg bg-indigo-500/15 border border-indigo-500/20 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-indigo-300" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                        <path d="M8 10h8M8 14h5M7 4h10a2 2 0 0 1 2 2v12l-4-2-4 2-4-2-4 2V6a2 2 0 0 1 2-2h2Z"
                                                              stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                                <h4 class="text-sm font-semibold text-white">
                                                    {{ __('AI Feedback') }}
                                                </h4>
                                            </div>

                                            @if(!empty($application->aiGeneratedFeedback))
                                                <p class="text-[15px] leading-8 text-gray-200 whitespace-normal break-words">
                                                    {{ $application->aiGeneratedFeedback }}
                                                </p>
                                            @else
                                                <p class="text-sm text-gray-400">
                                                    {{ __('No AI feedback available yet for this application.') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>