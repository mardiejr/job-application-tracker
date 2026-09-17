<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <p class="text-sm text-gray-500">Total Applications</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $total }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <p class="text-sm text-gray-500">Interviewing</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $chartData['interviewing'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <p class="text-sm text-gray-500">Offers</p>
                    <p class="text-3xl font-bold text-green-600">{{ $chartData['offer'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <p class="text-sm text-gray-500">Last 30 Days</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $recentCount }}</p>
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
                        <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 py-2">
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
                        legend: { position: 'bottom' }
                    }
                }
            });
        </script>
        @endpush
    @endif
</x-app-layout>
