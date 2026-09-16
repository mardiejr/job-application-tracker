<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Resumes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">Upload a Resume</h3>

                <form action="{{ route('resumes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Label</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            placeholder="e.g. Frontend Resume - 2026"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white text-sm">
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">File (PDF or Word, max 5MB)</label>
                        <input type="file" name="file" id="file" accept=".pdf,.doc,.docx"
                            class="mt-1 block w-full text-sm text-gray-700 dark:text-gray-300">
                        @error('file')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm">
                        Upload
                    </button>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">Your Resumes</h3>

                @forelse ($resumes as $resume)
                    <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 py-3">
                        <div>
                            <p class="text-gray-900 dark:text-gray-100">{{ $resume->name }}</p>
                            <p class="text-xs text-gray-500">{{ $resume->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="flex gap-4 items-center">
                            <a href="{{ asset('storage/' . $resume->file_path) }}" target="_blank" class="text-indigo-600 hover:underline text-sm">
                                Download
                            </a>
                            <form action="{{ route('resumes.destroy', $resume) }}" method="POST" onsubmit="return confirm('Delete this resume?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">No resumes uploaded yet.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
