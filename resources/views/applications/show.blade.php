<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $application->position }}
                </h2>
                <p class="text-sm text-gray-500 mt-0.5">{{ $application->company->name }}</p>
            </div>
            <a href="{{ route('applications.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to list
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-start mb-6">
                    <x-status-badge :status="$application->status" />
                    <div class="flex gap-2">
                        <a href="{{ route('applications.edit', $application) }}" class="inline-flex items-center gap-1.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-3 py-1.5 rounded-md text-sm font-medium transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('applications.destroy', $application) }}" method="POST" onsubmit="return confirm('Delete this application?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1.5 bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-md text-sm font-medium transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5">
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide">Company</dt>
                        <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $application->company->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide">Position</dt>
                        <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $application->position }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide">Applied Date</dt>
                        <dd class="mt-1 text-gray-900 dark:text-gray-100">
                            {{ $application->applied_date ? \Carbon\Carbon::parse($application->applied_date)->format('M d, Y') : '—' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide">Interview Date</dt>
                        <dd class="mt-1 text-gray-900 dark:text-gray-100">
                            {{ $application->interview_date ? \Carbon\Carbon::parse($application->interview_date)->format('M d, Y g:i A') : '—' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide">Resume</dt>
                        <dd class="mt-1 text-gray-900 dark:text-gray-100">
                            {{ $application->resume->name ?? '—' }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">Notes</h3>

                <form action="{{ route('notes.store', $application) }}" method="POST" class="mb-6">
                    @csrf
                    <textarea
                        name="content"
                        rows="3"
                        placeholder="Add a note (e.g. interview feedback, recruiter contact info)..."
                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white text-sm"
                    >{{ old('content') }}</textarea>
                    @error('content')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="mt-2 inline-flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Note
                    </button>
                </form>

                @forelse ($application->notes->sortByDesc('created_at') as $note)
                    <div class="border-t border-gray-100 dark:border-gray-700 py-3 flex justify-between items-start gap-4 first:border-t-0">
                        <div>
                            <p class="text-gray-900 dark:text-gray-100 text-sm">{{ $note->content }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $note->created_at->format('M d, Y g:i A') }}</p>
                        </div>
                        <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Delete this note?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">No notes yet.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
