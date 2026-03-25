<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <x-toast-notification />

    <!-- Toggle Active/Archived (Right aligned) -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        <div class="flex justify-end">
            @if (request('archived') == 'true')
                <a href="{{ route('User.index') }}"
                   class="inline-flex items-center text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                    View Active Users
                </a>
            @else
                <a href="{{ route('User.index', ['archived' => 'true']) }}"
                   class="inline-flex items-center text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                    View Archived Users
                </a>
            @endif
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
        <div class="overflow-x-auto relative shadow-md sm:rounded-lg p-4 bg-white">
            {{-- User Table --}}
            <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow bg-white">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User Name
                        </th>
                        <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>
                        <th scope="col" class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $u)
                        <tr class="bg-white border-b dark:bg-gray-100 dark:border-gray-200">
                            <td class="py-4 px-6">
                                {{ $u->name }}
                            </td>

                            <td class="py-4 px-6">
                                {{ $u->email }}
                            </td>

                            <td class="py-4 px-6">
                                {{ $u->role }}
                            </td>

                            <td class="py-4 px-6">
                                @if ($u->role === 'admin')
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-gray-700 bg-gray-200 rounded">
                                        Protected
                                    </span>
                                @else
                                    @if (!$u->deleted_at)
                                        <a href="{{ route('User.edit', $u->id) }}"
                                           class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-yellow-600 dark:hover:bg-yellow-700 focus:outline-none dark:focus:ring-yellow-800">
                                            Edit
                                        </a>

                                        <form action="{{ route('User.destroy', $u->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800"
                                                    onclick="return confirm('Are you sure you want to archive this user?');">
                                                Archive
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('User.restore', $u->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800"
                                                    onclick="return confirm('Are you sure you want to restore this user?');">
                                                Restore
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 px-6 text-center text-gray-500">
                                No Users Found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
