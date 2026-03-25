<nav class="w-[250px] bg-white h-screen border-r border-gray-200">
    <!-- Logo Section -->
    <div class="flex items-center px-6 border-b border-gray-200 py-4">
        <a href="{{ route('dashboard.index') }}" class="flex items-center space-x-2">
            <x-application-logo class="h-6 w-auto fill-current text-gray-800" />
            <span class="text-lg font-semibold text-gray-800"> {{ __('3ayenni') }}</span>
        </a>
    </div>

    <!-- Navigation Links -->
    <ul class="flex flex-col px-4 py-6 space-y-4">
        <x-nav-link :href="route('dashboard.index')" :active="request()->routeIs('dashboard.*')">
            {{ __('Dashboard') }}
        </x-nav-link>
        
        <!-- Show Companies link for both admin and company_owner users -->
        @if(auth()->user()->role == 'admin')
        <x-nav-link :href="route('Company.index')" :active="request()->routeIs('Company.*')">
            {{ __('Companies') }}
        </x-nav-link>
        @endif

        @if(auth()->user()->role === 'company_owner')
         <x-nav-link :href="route('my-company.show')" :active="request()->routeIs('my-company.*')">
            {{ __('My Company') }}
        </x-nav-link>
        @endif
        
        <x-nav-link :href="route('JobApplication.index')" :active="request()->routeIs('job-application.*')">
            {{ __('Job Applications') }}
        </x-nav-link>


        <!-- Show Categories link only for admin users -->
        @if(auth()->user()->role === 'admin')
        <x-nav-link :href="route('Job-category.index')" :active="request()->routeIs('Job-category.*')">
            {{ __('Categories') }}
        </x-nav-link>
        @endif

        <x-nav-link :href="route('JobVacancy.index')" :active="request()->routeIs('JobVacancy.*')">
            {{ __('Job Vacancies') }}
        </x-nav-link>
        <!-- SHOW users only admin -->
        @if(auth()->user()->role === 'admin')
        <x-nav-link :href="route('User.index')" :active="request()->routeIs('User.*')">
            {{ __('Users') }}
        </x-nav-link>
        @endif

        <hr />
        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <x-nav-link class="text-red-500" :href="route('logout')"
                onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-nav-link>
        </form>
    </ul>
</nav>