@php
    $colors = [
        'applied' => 'bg-blue-100 text-blue-800',
        'interviewing' => 'bg-yellow-100 text-yellow-800',
        'offer' => 'bg-green-100 text-green-800',
        'rejected' => 'bg-red-100 text-red-800',
        'withdrawn' => 'bg-gray-100 text-gray-800',
    ];
    $classes = $colors[$status] ?? 'bg-gray-100 text-gray-800';
@endphp

<span class="px-2.5 py-1 text-xs font-medium rounded-full capitalize {{ $classes }}">
    {{ $status }}
</span>
