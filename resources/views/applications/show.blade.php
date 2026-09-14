<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $application->position }} — {{ $application->company->name }}
            </h2>
            <a href="{{ route('applications.index') }}" class="text-sm text-gray-600 hover:underline">
                &larr; Back to list
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm text-gray-500">Company</dt>
                        <dd class="text-gray-900 dark:text-gray-100">{{ $application->company->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Position</dt>
                        <dd class="text-gray-900 dark:text-gray-100">{{ $application->position }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Status</dt>
                        <dd>
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 capitalize">
                                {{ $application->status }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Applied Date</dt>
                        <dd class="text-gray-900 dark:text-gray-100">
                            {{ $application->applied_date ? \Carbon\Carbon::parse($application->applied_date)->format('M d, Y') : '—' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Resume</dt>
                        <dd class="text-gray-900 dark:text-gray-100">
                            {{ $application->resume->name ?? '—' }}
                        </dd>
                    </div>
                </dl>

                <div class="mt-6 flex gap-4">
                    <a href="{{ route('applications.edit', $application) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm">
                        Edit
                    </a>
                    <form action="{{ route('applications.destroy', $application) }}" method="POST" onsubmit="return confirm('Delete this application?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm">
                            Delete
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">Notes</h3>

                @forelse ($application->notes as $note)
                    <div class="border-b border-gray-200 dark:border-gray-700 py-2">
                        <p class="text-gray-900 dark:text-gray-100">{{ $note->content }}</p>
                        <p class="text-xs text-gray-500">{{ $note->created_at->format('M d, Y g:i A') }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">No notes yet.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
