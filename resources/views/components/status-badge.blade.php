@props(['report', 'size' => 'md'])
@php
    $sb = $report->statusBadge;
    $colorClasses = match ($sb['color']) {
        'blue' => 'bg-slate-100 text-slate-700 ring-1 ring-slate-200',
        'yellow' => 'bg-amber-100 text-amber-700 ring-1 ring-amber-200',
        default => 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200',
    };
    $sizeClasses = $size === 'sm' ? 'px-2.5 py-0.5 text-xs font-semibold' : 'px-3 py-1 text-xs font-bold';
@endphp
<span {{ $attributes->merge(['class' => "$sizeClasses rounded-full $colorClasses"]) }}>
    {{ $sb['label'] }}
</span>
