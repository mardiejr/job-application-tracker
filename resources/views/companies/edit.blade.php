<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Company') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('companies.update', $company) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $company->name) }}"
                            class="block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location (optional)</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $company->location) }}"
                            class="block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('location')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Website (optional)</label>
                        <input type="url" name="website" id="website" value="{{ old('website', $company->website) }}"
                            class="block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('website')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-md text-sm font-medium transition">
                            Update Company
                        </button>
                        <a href="{{ route('companies.index') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 transition">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
