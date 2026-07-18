@props([
    'title' => 'Dashboard',
    'subtitle' => '',
])

@php
    $admin = auth('admin')->user();
    $initials = collect(explode(' ', $admin?->name ?? 'Admin'))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->implode('');
@endphp

<header class="admin-header sticky-top">
    <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
        <div class="d-flex align-items-start gap-3">
            <button class="btn admin-icon-btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebarOffcanvas">
                <i class="bi bi-list"></i>
            </button>
            <button class="btn admin-icon-btn d-none d-lg-inline-flex" type="button" id="sidebarCollapseToggle">
                <i class="bi bi-layout-sidebar-inset"></i>
            </button>
            <div>
                <h1 class="admin-page-title mb-1">{{ $title }}</h1>
                @if($subtitle)
                    <p class="admin-page-subtitle mb-0">{{ $subtitle }}</p>
                @endif
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 ms-auto">
            <div class="admin-search d-none d-md-flex">
                <i class="bi bi-search"></i>
                <input type="text" class="form-control" placeholder="Cari...">
            </div>

            <button class="btn admin-icon-btn position-relative" type="button">
                <i class="bi bi-bell"></i>
                <span class="admin-notification-dot"></span>
            </button>

            <div class="dropdown">
                <button class="btn admin-user-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="admin-user-avatar">{{ $initials ?: 'AD' }}</span>
                    <span class="d-none d-sm-inline-block text-start">
                        <strong class="d-block">{{ $admin?->name ?? 'Admin' }}</strong>
                        <small>Administrator</small>
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end admin-dropdown-menu shadow-sm border-0">
                    <li><a class="dropdown-item" href="{{ route('admin.profile.edit') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
