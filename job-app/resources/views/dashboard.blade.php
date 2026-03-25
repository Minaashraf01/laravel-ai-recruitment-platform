<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-black shadow-lg rounded-lg p-6 max-w-7xl mx-auto">
            <h3 class="text-white text-lg font-bold">
                {{ __('Welcome, ') }} {{ Auth::user()->name }}
            </h3>

            <!-- Search & Filter Section -->
            <div class="mt-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <!-- Search Form -->
                <div class="flex items-center gap-2">
                    <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-2">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search jobs..."
                            class="px-4 py-2 rounded-lg bg-white/10 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300"
                        >

                        {{-- keep filter when user searches --}}
                        @if(request()->filled('filter'))
                            <input type="hidden" name="filter" value="{{ request('filter') }}">
                        @endif

                        <button
                            type="submit"
                            class="px-4 py-2 bg-gradient-to-r from-pink-500 to-violet-500 text-white rounded-lg hover:from-pink-600 hover:to-violet-600 transition duration-300">
                            Search
                        </button>

                        {{-- Clear Filter (keep search only) --}}
                        @if(request()->filled('filter'))
                            <a
                                href="{{ route('dashboard', ['search' => request('search')]) }}"
                                class="ml-2 text-sm bg-red-500 px-3 py-1 rounded-lg hover:bg-red-600 transition duration-300"
                            >
                                Clear Filter
                            </a>
                        @endif

                        {{-- Clear Search (keep filter only) --}}
                        @if(request()->filled('search'))
                            <a
                                href="{{ route('dashboard', ['filter' => request('filter')]) }}"
                                class="ml-2 text-sm bg-red-500 px-3 py-1 rounded-lg hover:bg-red-600 transition duration-300"
                            >
                                Clear Search
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Filter Links -->
                <div class="flex items-center gap-4">
                    <a
                        href="{{ route('dashboard', ['filter' => 'full-time', 'search' => request('search')]) }}"
                        class="text-sm bg-indigo-500 px-3 py-1 rounded-lg hover:bg-indigo-600 transition duration-300"
                    >
                        Full Time
                    </a>

                    <a
                        href="{{ route('dashboard', ['filter' => 'Remote', 'search' => request('search')]) }}"
                        class="text-sm bg-indigo-500 px-3 py-1 rounded-lg hover:bg-indigo-600 transition duration-300"
                    >
                        Remote
                    </a>

                    <a
                        href="{{ route('dashboard', ['filter' => 'Contract', 'search' => request('search')]) }}"
                        class="text-sm bg-indigo-500 px-3 py-1 rounded-lg hover:bg-indigo-600 transition duration-300"
                    >
                        Contract
                    </a>

                    <a
                        href="{{ route('dashboard', ['filter' => 'Hybrid', 'search' => request('search')]) }}"
                        class="text-sm bg-indigo-500 px-3 py-1 rounded-lg hover:bg-indigo-600 transition duration-300"
                    >
                        Hybrid
                    </a>
                </div>
            </div>

            <!-- Job Listings Section -->
            <div class="space-y-4 mt-6">
                <div class="bg-white/10 p-4 rounded-lg">
                    @forelse ($jobs as $job)
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <a href="{{ route('job-vacancies.show', $job->id) }}" class="text-lg font-bold text-blue-400 hover:text-purple-400 transition duration-300">
                                    {{ $job->title }}
                                </a>
                                <p class="text-gray-400">{{ $job->company }} - {{ $job->location }}</p>
                                <p class="text-sm text-gray-400">${{ number_format($job->salary) }}/year</p>
                                <p class="text-sm text-gray-400">Posted {{ $job->created_at->diffForHumans() }}</p>
                            </div>

                            <span class="inline-block bg-indigo-500 text-white px-5 py-2 rounded-lg text-sm">
                                {{ $job->type }}
                            </span>
                        </div>

                        <hr class="border-gray-700 my-4">
                    @empty
                        <p class="text-gray-400">No jobs available.</p>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>