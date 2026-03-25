<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job Application') }}
        </h2>
    </x-slot>

    <x-toast-notification />

    @php
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
    @endphp

    <!-- Edit Job Application Form -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6 mb-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left Side: Application Details -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Applicant Details Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Application Details</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Job Vacancy</label>
                                <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-gray-900">
                                    {{ $jobApplication->jobVacancy->title ?? 'N/A' }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Summary</label>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-4 text-gray-900 leading-relaxed">
                                {{ $jobApplication->resume->summary ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- AI Feedback Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">AI Feedback</h3>
 
                        </div>

                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                                {{ $jobApplication->aiGeneratedFeedback ?? 'No AI feedback available.' }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Side: Score + Status Form -->
            <div class="space-y-6">

                <!-- Score Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">AI Score</h3>

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

                            <p class="text-sm text-gray-500">
                                This score reflects how well the applicant matches the job requirements based on AI analysis.
                            </p>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-500">
                                N/A
                            </span>
                            <p class="text-sm text-gray-500 mt-3">
                                AI score is not available for this application.
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Update Status Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Update Status</h3>

                        <form action="{{ route('JobApplication.update', $jobApplication->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-5">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Applicant Status
                                </label>

                                <select id="status"
                                        name="status"
                                        class="block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-2 focus:ring-blue-300 focus:border-blue-400">
                                    @foreach (['Pending', 'Accepted', 'Rejected'] as $status)
                                        <option value="{{ $status }}" {{ $jobApplication->status === $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('status')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center gap-3">
                                <button type="submit"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                    Update Applicant Status
                                </button>

                                <a href="{{ route('JobApplication.index') }}"
                                   class="text-gray-700 hover:text-gray-900 font-medium">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>