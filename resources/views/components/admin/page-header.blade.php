@props([
    'title' => '',
    'subtitle' => '',
])

@php
    $currentTitle = trim($__env->yieldContent('title'));
    $currentSubtitle = trim($__env->yieldContent('page_subtitle'));
    $showHeading = $title !== '' && ($currentTitle !== trim($title) || $currentSubtitle !== trim($subtitle));
    $hasActions = trim((string) $slot) !== '';
@endphp

@if($showHeading || $hasActions)
    <div class="admin-section-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
        @if($showHeading)
            <div>
                <h2 class="admin-section-title mb-1">{{ $title }}</h2>
                @if($subtitle)
                    <p class="admin-section-subtitle mb-0">{{ $subtitle }}</p>
                @endif
            </div>
        @endif

        @if($hasActions)
            <div class="admin-section-actions {{ $showHeading ? '' : 'ms-lg-auto' }}">
            {{ $slot }}
            </div>
        @endif
    </div>
@endif
