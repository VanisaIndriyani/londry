@props([
    'title' => '',
    'value' => '0',
    'icon' => 'bi-graph-up',
    'variant' => 'primary',
])

<div class="admin-stat-card admin-stat-card--{{ $variant }}">
    <div class="d-flex justify-content-between align-items-start gap-3">
        <div>
            <div class="admin-stat-card__title">{{ $title }}</div>
            <div class="admin-stat-card__value counter" data-target="{{ preg_replace('/[^\d]/', '', (string) $value) ?: 0 }}">{{ $value }}</div>
        </div>
        <div class="admin-stat-card__icon">
            <i class="bi {{ $icon }}"></i>
        </div>
    </div>
</div>
