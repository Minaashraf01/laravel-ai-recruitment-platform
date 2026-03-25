<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Categories') }}
        </h2>
        
    </x-slot>
    <x-toast-notification />

    <!--Archived-->
    
    <div class="mb-4">
    @if (request()->has('archived') && request('archived') == 'true')
        <a href="{{ route('Job-category.index') }}" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">View Active Categories</a>
    @else
        <a href="{{ route('Job-category.index', ['archived' => 'true']) }}" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">View Archived Categories</a>
    @endif
    </div>

    <div class="overflow-x-auto relative shadow-md sm:rounded-lg p-4 bg-white">
        <a href="{{ route('Job-category.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"> Add New Category</a>
        {{--Job Category Table --}}
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Name
                    </th>
                    <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jobCategories as $category)
                    <tr class="bg-white border-b dark:bg-gray-100 dark:border-gray-200">

                        <td class="py-4 px-6">
                            {{ $category->name }}
                        </td>
                        <td class="py-4 px-6">
                        <!-- Edit and Archive/Restore Buttons -->
                            @if (!$category->deleted_at)
                                <a href="{{ route('Job-category.edit', $category->id) }}" class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-yellow-600 dark:hover:bg-yellow-700 focus:outline-none dark:focus:ring-yellow-800">Edit</a>
                                <form action="{{ route('Job-category.destroy', $category->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800" onclick="return confirm('Are you sure you want to archive this category?');">Archive</button>
                                </form>
                            @else
                            <form action="{{ route('Job-category.restore', $category->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800" onclick="return confirm('Are you sure you want to restore this category?');">Restore</button>
                            </form> 
                            @endif 
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="py-4 px-6 text-center text-gray-500">
                            No Job Categories Found.
                        </td>       
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $jobCategories->links() }}
        </div>
    </div>
</x-app-layout>
