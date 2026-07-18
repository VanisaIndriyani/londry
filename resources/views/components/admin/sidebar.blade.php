@php
    $menuItems = [
        ['label' => 'Dashboard', 'icon' => 'bi-grid-1x2-fill', 'route' => 'admin.dashboard', 'active' => request()->routeIs('admin.dashboard')],
        ['label' => 'Pesanan', 'icon' => 'bi-box-seam-fill', 'route' => 'admin.orders.index', 'active' => request()->routeIs('admin.orders.*')],
        ['label' => 'Layanan', 'icon' => 'bi-basket2-fill', 'route' => 'admin.services.index', 'active' => request()->routeIs('admin.services.*')],
        ['label' => 'Transaksi', 'icon' => 'bi-credit-card-2-front-fill', 'route' => 'admin.transactions.index', 'active' => request()->routeIs('admin.transactions.*')],
        ['label' => 'Laporan', 'icon' => 'bi-bar-chart-line-fill', 'route' => 'admin.reports.index', 'active' => request()->routeIs('admin.reports.*')],
        ['label' => 'Pengaturan', 'icon' => 'bi-sliders2', 'route' => 'admin.settings.index', 'active' => request()->routeIs('admin.settings.*')],
        ['label' => 'Profil', 'icon' => 'bi-person-circle', 'route' => 'admin.profile.edit', 'active' => request()->routeIs('admin.profile.*')],
    ];
@endphp

<aside class="admin-sidebar d-flex flex-column" id="adminSidebar">
    <div class="admin-sidebar__brand d-flex align-items-center gap-3">
        <div class="admin-sidebar__brand-icon">
            @if(!empty($appSettings['logo']))
                <img src="{{ \App\Support\AdminSettings::logoUrl($appSettings['logo']) }}" alt="Logo Laundry" class="admin-brand-image">
            @else
                <i class="bi bi-droplet-half"></i>
            @endif
        </div>
        <div>
            <div class="admin-sidebar__brand-title">Laundry Admin</div>
        </div>
    </div>

    <nav class="nav flex-column gap-1">
        @foreach($menuItems as $item)
            <a href="{{ route($item['route']) }}" class="admin-sidebar__link {{ $item['active'] ? 'is-active' : '' }}">
                <span class="admin-sidebar__link-icon"><i class="bi {{ $item['icon'] }}"></i></span>
                <span class="admin-sidebar__link-text">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="admin-sidebar__bottom mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="admin-sidebar__logout w-100">
                <span class="admin-sidebar__link-icon"><i class="bi bi-box-arrow-right"></i></span>
                <span class="admin-sidebar__link-text">Logout</span>
            </button>
        </form>
    </div>
</aside>
