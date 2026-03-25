<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div class="min-w-0">
                <h2 class="font-semibold text-xl text-white leading-tight truncate">
                    {{ $jobVacancies->title }} <span class="text-gray-300"></span>
                </h2>
                <p class="text-sm text-gray-300 mt-1 truncate">
                    {{ $jobVacancies->company }} • {{ $jobVacancies->location }}
                </p>
            </div>

            <a href="{{ route('job-vacancies.show', $jobVacancies->id) }}"
                class="shrink-0 inline-flex items-center gap-2 text-sm text-gray-100 bg-white/10 px-4 py-2 rounded-xl
                      hover:bg-white/15 border border-white/10 transition
                      focus:outline-none focus:ring-2 focus:ring-indigo-400/50">
                <span aria-hidden="true">&larr;</span>
                Back to Job Details
            </a>
        </div>
    </x-slot>

    <div class="py-12">

        <!-- Hero -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="relative overflow-hidden rounded-3xl border border-white/10 bg-gradient-to-br from-white/10 via-black/60 to-black shadow-2xl">
                <div class="absolute inset-0 pointer-events-none opacity-40"
                    style="background: radial-gradient(700px circle at 20% 10%, rgba(99,102,241,.35), transparent 60%),
                                    radial-gradient(700px circle at 80% 30%, rgba(236,72,153,.25), transparent 60%);">
                </div>

                <div class="relative p-6 sm:p-10">
                    <h1 class="text-2xl sm:text-4xl font-bold text-white tracking-tight">
                        Apply for {{ $jobVacancies->title }}
                    </h1>

                    <div class="mt-5 flex flex-wrap items-center gap-2 text-sm text-gray-200">
                        <span
                            class="inline-flex items-center rounded-full bg-white/10 border border-white/10 px-3 py-1">
                            {{ $jobVacancies->company }}
                        </span>
                        <span
                            class="inline-flex items-center rounded-full bg-white/10 border border-white/10 px-3 py-1">
                            {{ $jobVacancies->location }}
                        </span>
                        <span
                            class="inline-flex items-center rounded-full bg-indigo-500/80 border border-indigo-300/20 px-3 py-1 font-medium text-white">
                            {{ $jobVacancies->type }}
                        </span>
                        <span
                            class="inline-flex items-center rounded-full bg-white/10 border border-white/10 px-3 py-1">
                            Salary:
                            <span class="ml-1 font-semibold text-white">
                                ${{ number_format($jobVacancies->salary) }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content (Full width) -->
        <div class="mt-12 w-full px-4 sm:px-10 lg:px-16">
            <div class="w-full">
                <div
                    class="rounded-3xl bg-white/[0.06] border border-white/10 overflow-hidden shadow-2xl shadow-black/40">
                    <!-- Top Accent -->
                    <div class="h-1.5 bg-gradient-to-r from-indigo-500 via-pink-500 to-violet-500"></div>

                    <div class="p-6 sm:p-10 lg:p-12">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <h3 class="text-2xl font-semibold text-white">Application Form</h3>
                                <p class="text-gray-300 mt-2">
                                    Upload your resume and complete your application.
                                </p>
                            </div>

                            <span
                                class="inline-flex items-center gap-2 text-xs text-gray-200 bg-white/10 border border-white/10 px-4 py-2 rounded-full">
                                Resume Required
                            </span>
                        </div>

                        <div class="mt-8 border-t border-white/10"></div>

                        <form action="{{ route('job-vacancies.processApplication', $jobVacancies->id) }}" method="POST"
                            enctype="multipart/form-data" class="mt-8 space-y-8">
                            @csrf

                            @error('resume')
                                <div
                                    class="mt-4 flex items-start gap-3 p-4 rounded-2xl 
                bg-red-500/10 border border-red-500/30 
                text-red-300 shadow-lg shadow-red-500/10">

                                    <svg class="w-5 h-5 mt-0.5 text-red-400 shrink-0" fill="none" stroke="currentColor"
                                        stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 4h.01M4.93 19h14.14c1.54 0 2.5-1.67
                       1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.2 16c-.77
                       1.33.19 3 1.73 3z" />
                                    </svg>

                                    <div>
                                        <p class="font-semibold">Upload Error</p>
                                        <p class="text-sm mt-1">{{ $message }}</p>
                                    </div>
                                </div>
                            @enderror

                            <!-- Resume Upload -->
                            <div>
                                <label class="block text-sm font-medium text-gray-200">
                                    Upload Resume
                                </label>

                                <div id="dropzone"
                                    class="mt-4 flex flex-col items-center justify-center text-center
                                            border-2 border-dashed border-white/20
                                            rounded-2xl p-10 cursor-pointer
                                            bg-black/20 hover:bg-black/30
                                            hover:border-indigo-400 transition select-none
                                            focus-within:ring-2 focus-within:ring-indigo-400/50 focus-within:border-indigo-400">
                                    <svg class="w-10 h-10 text-gray-300 mb-4" fill="none" stroke="currentColor"
                                        stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 16V4m0 0 4 4m-4-4-4 4M4 16v3a1 1 0 001 1h14a1 1 0 001-1v-3" />
                                    </svg>

                                    <p class="text-white font-medium">
                                        Click to upload <span class="text-gray-300 font-normal">or drag & drop</span>
                                    </p>

                                    <p id="file-name" class="text-gray-400 text-sm mt-2">
                                        No file selected
                                    </p>

                                    <input type="file" name="resume" id="resume" class="hidden" accept=".pdf" />
                                </div>

                                <p class="text-xs text-gray-400 mt-2">
                                    Supported: PDF only
                                </p>

                            </div>

                            <script>
                                (function() {
                                    const dropzone = document.getElementById('dropzone');
                                    const input = document.getElementById('resume');
                                    const fileName = document.getElementById('file-name');

                                    if (!dropzone || !input || !fileName) return;

                                    // Click opens file picker
                                    dropzone.addEventListener('click', () => input.click());

                                    // Show chosen file name (normal selection)
                                    input.addEventListener('change', () => {
                                        fileName.textContent = input.files && input.files[0] ? input.files[0].name : 'No file selected';
                                        fileName.classList.toggle('text-emerald-400', !!(input.files && input.files.length));
                                        fileName.classList.toggle('text-gray-400', !(input.files && input.files.length));
                                    });

                                    // Prevent browser from opening the file
                                    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(evt => {
                                        dropzone.addEventListener(evt, (e) => {
                                            e.preventDefault();
                                            e.stopPropagation();
                                        });
                                    });

                                    // Visual highlight
                                    ['dragenter', 'dragover'].forEach(evt => {
                                        dropzone.addEventListener(evt, () => {
                                            dropzone.classList.add('border-indigo-400', 'bg-white/5');
                                        });
                                    });
                                    ['dragleave', 'drop'].forEach(evt => {
                                        dropzone.addEventListener(evt, () => {
                                            dropzone.classList.remove('border-indigo-400', 'bg-white/5');
                                        });
                                    });

                                    // Handle drop
                                    dropzone.addEventListener('drop', (e) => {
                                        const files = e.dataTransfer.files;
                                        if (!files || !files.length) return;

                                        // Allow only one file (resume)
                                        input.files = files;

                                        // Trigger change to update UI
                                        input.dispatchEvent(new Event('change', {
                                            bubbles: true
                                        }));
                                    });
                                })();
                            </script>

                            <!-- Submit -->
                            <button type="submit"
                                class="w-full py-4 text-lg font-semibold rounded-2xl
                                           bg-gradient-to-r from-pink-500 to-violet-500
                                           hover:from-pink-600 hover:to-violet-600
                                           text-white shadow-xl shadow-pink-500/15 transition
                                           focus:outline-none focus:ring-2 focus:ring-pink-400/60">
                                Submit Application
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
