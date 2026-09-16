<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Job Applications') }}
            </h2>
            <a href="{{ route('applications.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm">
                + New Application
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="GET" action="{{ route('applications.index') }}" class="flex flex-wrap gap-3 mb-6">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search company or position..."
                        class="flex-1 min-w-[200px] rounded-md border-gray-300 dark:bg-gray-700 dark:text-white text-sm"
                    >

                    <select name="status" class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-white text-sm">
                        <option value="">All Statuses</option>
                        @foreach (['applied', 'interviewing', 'offer', 'rejected', 'withdrawn'] as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-md text-sm">
                        Filter
                    </button>

                    @if (request('search') || request('status'))
                        <a href="{{ route('applications.index') }}" class="text-sm text-gray-500 hover:underline self-center">
                            Clear
                        </a>
                    @endif
                </form>

                @if ($applications->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">
                        No applications match your search.
                    </p>
                @else
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Company</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Position</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Applied Date</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($applications as $application)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $application->company->name }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $application->position }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 capitalize">
                                            {{ $application->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-500">
                                        {{ $application->applied_date ? \Carbon\Carbon::parse($application->applied_date)->format('M d, Y') : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right space-x-2">
                                        <a href="{{ route('applications.show', $application) }}" class="text-indigo-600 hover:underline">View</a>
                                        <a href="{{ route('applications.edit', $application) }}" class="text-gray-600 hover:underline">Edit</a>
                                        <form action="{{ route('applications.destroy', $application) }}" method="POST" class="inline" onsubmit="return confirm('Delete this application?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-6">
                        {{ $applications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
