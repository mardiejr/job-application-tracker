<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Job Application') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('applications.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="company_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company</label>
                        <select name="company_id" id="company_id" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white">
                            <option value="">-- Select a company --</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('company_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Position</label>
                        <input type="text" name="position" id="position" value="{{ old('position') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white"
                            placeholder="e.g. Frontend Developer">
                        @error('position')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white">
                            <option value="applied">Applied</option>
                            <option value="interviewing">Interviewing</option>
                            <option value="offer">Offer</option>
                            <option value="rejected">Rejected</option>
                            <option value="withdrawn">Withdrawn</option>
                        </select>
                        @error('status')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="applied_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Applied Date</label>
                        <input type="date" name="applied_date" id="applied_date" value="{{ old('applied_date') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white">
                        @error('applied_date')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="interview_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Interview Date & Time (optional)</label>
                        <input type="datetime-local" name="interview_date" id="interview_date" value="{{ old('interview_date') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white">
                        @error('interview_date')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="resume_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Resume (optional)</label>
                        <select name="resume_id" id="resume_id" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white">
                            <option value="">-- None --</option>
                            @foreach ($resumes as $resume)
                                <option value="{{ $resume->id }}" {{ old('resume_id') == $resume->id ? 'selected' : '' }}>
                                    {{ $resume->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm">
                            Save Application
                        </button>
                        <a href="{{ route('applications.index') }}" class="text-sm text-gray-600 hover:underline">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
