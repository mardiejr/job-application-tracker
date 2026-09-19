<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Job Application') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('applications.update', $application) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="company_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Company</label>
                            <select name="company_id" id="company_id" class="block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id', $application->company_id) == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('company_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Position</label>
                            <input type="text" name="position" id="position" value="{{ old('position', $application->position) }}"
                                class="block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('position')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                            <select name="status" id="status" class="block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach (['applied', 'interviewing', 'offer', 'rejected', 'withdrawn'] as $status)
                                    <option value="{{ $status }}" {{ old('status', $application->status) == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="applied_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Applied Date</label>
                            <input type="date" name="applied_date" id="applied_date"
                                value="{{ old('applied_date', $application->applied_date ? \Carbon\Carbon::parse($application->applied_date)->format('Y-m-d') : '') }}"
                                class="block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('applied_date')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="interview_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Interview Date &amp; Time (optional)</label>
                        <input type="datetime-local" name="interview_date" id="interview_date"
                            value="{{ old('interview_date', $application->interview_date ? \Carbon\Carbon::parse($application->interview_date)->format('Y-m-d\TH:i') : '') }}"
                            class="block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('interview_date')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                        <label for="resume_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Resume (optional)</label>
                        <select name="resume_id" id="resume_id" class="block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- None --</option>
                            @foreach ($resumes as $resume)
                                <option value="{{ $resume->id }}" {{ old('resume_id', $application->resume_id) == $resume->id ? 'selected' : '' }}>
                                    {{ $resume->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-md text-sm font-medium transition">
                            Update Application
                        </button>
                        <a href="{{ route('applications.index') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 transition">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
