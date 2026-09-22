<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 flex items-start gap-4">
                    <div
                        class="h-10 w-10 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Applications</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $total }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 flex items-start gap-4">
                    <div
                        class="h-10 w-10 rounded-lg bg-yellow-50 dark:bg-yellow-900/30 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Interviewing</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $chartData['interviewing'] }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 flex items-start gap-4">
                    <div
                        class="h-10 w-10 rounded-lg bg-green-50 dark:bg-green-900/30 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Offers</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $chartData['offer'] }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 flex items-start gap-4">
                    <div
                        class="h-10 w-10 rounded-lg bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Last 30 Days</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $recentCount }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">Status Breakdown</h3>
                    @if ($total > 0)
                        <canvas id="statusChart" height="220"></canvas>
                    @else
                        <p class="text-gray-500 text-sm">No applications yet — add one to see your breakdown.</p>
                    @endif
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">Recent Applications</h3>
                    @forelse ($recentApplications as $application)
                        <div
                            class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 py-2">
                            <div>
                                <p class="text-gray-900 dark:text-gray-100 text-sm">{{ $application->position }}</p>
                                <p class="text-xs text-gray-500">{{ $application->company->name }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 capitalize">
                                {{ $application->status }}
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">No applications yet.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    @if ($total > 0)
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
            <script>
                const ctx = document.getElementById('statusChart');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Applied', 'Interviewing', 'Offer', 'Rejected', 'Withdrawn'],
                        datasets: [{
                            data: [
                                {{ $chartData['applied'] }},
                                {{ $chartData['interviewing'] }},
                                {{ $chartData['offer'] }},
                                {{ $chartData['rejected'] }},
                                {{ $chartData['withdrawn'] }}
                            ],
                            backgroundColor: [
                                '#60a5fa',
                                '#fbbf24',
                                '#34d399',
                                '#f87171',
                                '#9ca3af'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            </script>
        @endpush
    @endif
</x-app-layout>
