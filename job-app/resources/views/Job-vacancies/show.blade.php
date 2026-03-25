<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ $jobVacancies->title }}
                </h2>
                <p class="text-sm text-gray-300 mt-1">
                    {{ $jobVacancies->company }} • {{ $jobVacancies->location }}
                </p>
            </div>

            <a href="{{ route('dashboard') }}"
               class="shrink-0 inline-flex items-center gap-2 text-sm text-gray-100 bg-white/10 px-4 py-2 rounded-xl hover:bg-white/15 border border-white/10 transition">
                <span aria-hidden="true">&larr;</span>
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero -->
            <div class="relative overflow-hidden rounded-3xl border border-white/10 bg-gradient-to-br from-white/10 via-black/60 to-black shadow-2xl">
                <div class="absolute inset-0 pointer-events-none opacity-40"
                     style="background: radial-gradient(700px circle at 20% 10%, rgba(99,102,241,.35), transparent 60%),
                                    radial-gradient(700px circle at 80% 30%, rgba(236,72,153,.25), transparent 60%);">
                </div>

                <div class="relative p-6 sm:p-10">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0">
                            <h1 class="text-2xl sm:text-4xl font-bold text-white tracking-tight">
                                {{ $jobVacancies->title }}
                            </h1>

                            <div class="mt-3 flex flex-wrap items-center gap-2 text-sm text-gray-200">
                                <span class="inline-flex items-center rounded-full bg-white/10 border border-white/10 px-3 py-1">
                                    {{ $jobVacancies->company }}
                                </span>
                                <span class="text-white/30">•</span>
                                <span class="inline-flex items-center rounded-full bg-white/10 border border-white/10 px-3 py-1">
                                    {{ $jobVacancies->location }}
                                </span>
                                <span class="text-white/30">•</span>
                                <span class="inline-flex items-center rounded-full bg-indigo-500/80 border border-indigo-300/20 px-3 py-1 font-medium text-white">
                                    {{ $jobVacancies->type }}
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col sm:items-end gap-3">
                            <a href="{{ route('job-vacancies.apply', $jobVacancies->id) }}"
                               class="inline-flex items-center justify-center px-8 py-3 text-base font-semibold rounded-2xl
                                      bg-gradient-to-r from-pink-500 to-violet-500 text-white
                                      hover:from-pink-600 hover:to-violet-600 transition
                                      shadow-lg shadow-pink-500/20 focus:outline-none focus:ring-2 focus:ring-pink-400/60">
                                Apply for this Job
                            </a>

                            <p class="text-xs text-gray-300">
                                Posted on: <span class="text-gray-100 font-medium">{{ $jobVacancies->created_at->format('F j, Y') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Left -->
                <div class="lg:col-span-8">
                    <!-- Quick stats -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="rounded-2xl bg-white/5 border border-white/10 p-5">
                            <p class="text-xs uppercase tracking-wider text-gray-400">Salary</p>
                            <p class="mt-2 text-lg font-semibold text-white">
                                ${{ number_format($jobVacancies->salary) }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-white/5 border border-white/10 p-5">
                            <p class="text-xs uppercase tracking-wider text-gray-400">Employment Type</p>
                            <p class="mt-2 text-lg font-semibold text-white">
                                {{ $jobVacancies->type }}
                            </p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-6 rounded-2xl bg-white/5 border border-white/10 p-6 sm:p-7">
                        <div class="flex items-center justify-between gap-4">
                            <h3 class="text-xl font-semibold text-white">Job Description</h3>
                            <span class="hidden sm:inline-flex text-xs text-gray-300 bg-white/10 border border-white/10 px-3 py-1 rounded-full">
                                Details
                            </span>
                        </div>

                        <div class="mt-4 border-t border-white/10"></div>

                        <p class="mt-5 text-gray-200 leading-relaxed whitespace-pre-line">
                            {{ $jobVacancies->description }}
                        </p>

                        <!-- Bottom Apply (mobile-friendly) -->
                        <div class="mt-8 lg:hidden">
                            <a href="{{ route('job-vacancies.apply', $jobVacancies->id) }}"
                               class="w-full inline-flex items-center justify-center px-8 py-3 text-base font-semibold rounded-2xl
                                      bg-gradient-to-r from-pink-500 to-violet-500 text-white
                                      hover:from-pink-600 hover:to-violet-600 transition
                                      shadow-lg shadow-pink-500/20 focus:outline-none focus:ring-2 focus:ring-pink-400/60">
                                Apply for this Job
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right (Overview) -->
                <aside class="lg:col-span-4">
                    <div class="lg:sticky lg:top-6 rounded-2xl bg-white/5 border border-white/10 p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-white">Job Overview</h3>
                            <span class="text-xs text-gray-300 bg-white/10 border border-white/10 px-3 py-1 rounded-full">
                                Summary
                            </span>
                        </div>

                        <div class="mt-4 space-y-4">
                            <div class="flex items-start justify-between gap-4">
                                <p class="text-sm text-gray-400">Company</p>
                                <p class="text-sm text-gray-100 font-medium text-right">{{ $jobVacancies->company }}</p>
                            </div>
                            <div class="h-px bg-white/10"></div>

                            <div class="flex items-start justify-between gap-4">
                                <p class="text-sm text-gray-400">Location</p>
                                <p class="text-sm text-gray-100 font-medium text-right">{{ $jobVacancies->location }}</p>
                            </div>
     
                            <div class="h-px bg-white/10"></div>

                            <div class="flex items-start justify-between gap-4">
                                <p class="text-sm text-gray-400">Salary</p>
                                <p class="text-sm text-gray-100 font-medium text-right">
                                    ${{ number_format($jobVacancies->salary) }}
                                </p>
                            </div>
                            <div class="h-px bg-white/10"></div>

                            <div class="flex items-start justify-between gap-4">
                                <p class="text-sm text-gray-400">Posted on</p>
                                <p class="text-sm text-gray-100 font-medium text-right">
                                    {{ $jobVacancies->created_at->format('F j, Y') }}
                                </p>
                            </div>
                        </div>

                   
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>