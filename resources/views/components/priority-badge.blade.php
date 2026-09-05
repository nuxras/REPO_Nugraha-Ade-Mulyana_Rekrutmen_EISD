@props(['report', 'mode' => 'score-label', 'size' => 'md'])
@php
    $pb = $report->priorityBadge;
    $colorClasses = match ($pb['color']) {
        'red' => 'bg-red-100 text-red-700 ring-1 ring-red-200',
        'yellow' => 'bg-amber-100 text-amber-700 ring-1 ring-amber-200',
        default => 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200',
    };
    $sizeClasses = $size === 'sm' ? 'px-2.5 py-0.5 text-xs font-semibold' : 'px-3 py-1 text-xs font-bold';
    $text = match ($mode) {
        'score' => 'Skor: ' . $report->priority_score,
        'label-score' => 'Prioritas: ' . $pb['label'] . ' (' . $report->priority_score . ')',
        'label' => $pb['label'],
        default => 'Skor: ' . $report->priority_score . ' (' . $pb['label'] . ')',
    };
@endphp
<span {{ $attributes->merge(['class' => "$sizeClasses rounded-full $colorClasses"]) }}>
    {{ $text }}
</span>
