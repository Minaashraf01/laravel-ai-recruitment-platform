<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }}
        </h2>
    </x-slot>
    <x-toast-notification />
<!-- Archived toggle (right aligned) -->
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
    <div class="flex justify-end">
        @if (request('archived') == 'true')
            <a href="{{ route('Company.index') }}"
               class="inline-flex items-center text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                View Active Companies
            </a>
        @else
            <a href="{{ route('Company.index', ['archived' => 'true']) }}"
               class="inline-flex items-center text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                View Archived Companies
            </a>
        @endif
    </div>
</div>

    <div class="overflow-x-auto relative shadow-md sm:rounded-lg p-4 bg-gray-100">
        <!-- Add New Company Button -->
        <a href="{{ route('Company.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"> Add New Company</a>
        {{--Company Table --}}
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Name
                    </th>
                    <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        address
                    </th>
                    <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        industry
                    </th>
                    <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        website
                    </th>

                    <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>

                @forelse ($companies as $company)
                    <tr class="bg-white border-b dark:bg-gray-100 dark:border-gray-200">

                        <td class="py-4 px-6">
                           <a href="{{ route('Company.show', $company->id) }}" class="text-blue-600 hover:text-blue-800">{{ $company->name }}</a>
                        </td>
                        <td class="py-4 px-6">
                            {{ $company->address }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $company->industry }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $company->website }}
                        </td>
                        <td class="py-4 px-6">
                        <!-- Edit and Archive/Restore Buttons -->
                            @if (!$company->deleted_at)
                                <a href="{{ route('Company.edit', $company->id) }}" class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-yellow-600 dark:hover:bg-yellow-700 focus:outline-none dark:focus:ring-yellow-800">Edit</a>
                                <form action="{{ route('Company.destroy', $company->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800" >Archive</button>
                                </form>
                            @else
                            <form action="{{ route('Company.restore', $company->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">Restore</button>
                            </form> 
                            @endif 
                    </tr>   
                @empty
                    <tr>
                        <td colspan="2" class="py-4 px-6 text-center text-gray-500">
                            No Companies Found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
                        {{ $companies->links() }}
                    </div>
</x-app-layout>
