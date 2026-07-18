<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin') - Laundry Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --admin-primary: #2563EB;
            --admin-primary-dark: #1D4ED8;
            --admin-sidebar: #0F172A;
            --admin-background: #F8FAFC;
            --admin-card: #FFFFFF;
            --admin-text: #1E293B;
            --admin-muted: #64748B;
            --admin-line: #E2E8F0;
            --admin-success: #10B981;
            --admin-warning: #F59E0B;
            --admin-danger: #EF4444;
            --admin-radius: 18px;
            --admin-sidebar-width: 270px;
            --admin-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
        }

        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--admin-background);
            color: var(--admin-text);
            overflow: hidden;
            font-size: 14px;
        }

        .admin-app {
            min-height: 100vh;
        }

        .admin-sidebar-shell {
            width: var(--admin-sidebar-width);
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1040;
            background: var(--admin-sidebar);
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s ease, width 0.3s ease;
        }

        .admin-content-shell {
            margin-left: var(--admin-sidebar-width);
            min-height: 100vh;
            height: 100vh;
            overflow-y: auto;
            transition: margin-left 0.3s ease;
        }

        body.sidebar-collapsed .admin-sidebar-shell {
            width: 92px;
        }

        body.sidebar-collapsed .admin-content-shell {
            margin-left: 92px;
        }

        body.sidebar-collapsed .admin-sidebar__brand-subtitle,
        body.sidebar-collapsed .admin-sidebar__menu-label,
        body.sidebar-collapsed .admin-sidebar__link-text {
            display: none;
        }

        body.sidebar-collapsed .admin-sidebar__brand {
            justify-content: center;
        }

        body.sidebar-collapsed .admin-sidebar__bottom .admin-sidebar__logout {
            justify-content: center;
        }

        .admin-sidebar {
            min-height: 100%;
            padding: 1.5rem 1rem;
            color: #cbd5e1;
        }

        .admin-sidebar__brand {
            padding: 0.85rem;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.06);
            margin-bottom: 1.6rem;
        }

        .admin-sidebar__brand-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, #2563EB 0%, #60A5FA 100%);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.45rem;
            box-shadow: 0 14px 34px rgba(37, 99, 235, 0.25);
        }

        .admin-brand-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 16px;
            display: block;
        }

        .admin-sidebar__brand-title {
            color: #fff;
            font-weight: 700;
        }

        .admin-sidebar__brand-subtitle {
            font-size: 0.72rem;
            color: #94A3B8;
        }

        .admin-sidebar__link,
        .admin-sidebar__logout {
            display: flex;
            align-items: center;
            gap: 0.95rem;
            border: 0;
            width: 100%;
            background: transparent;
            color: #CBD5E1;
            text-decoration: none;
            padding: 0.9rem 1rem;
            border-radius: 16px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .admin-sidebar__link-icon {
            width: 22px;
            text-align: center;
            font-size: 1.2rem;
        }

        .admin-sidebar__link:hover,
        .admin-sidebar__logout:hover,
        .admin-sidebar__link.is-active {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.20), rgba(96, 165, 250, 0.20));
            color: #fff;
            transform: translateX(4px);
        }

        .admin-main {
            padding: 1.75rem;
        }

        .admin-header {
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(226, 232, 240, 0.78);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
            border-radius: 22px;
            padding: 1rem 1.2rem;
            margin-bottom: 1.5rem;
            top: 0;
            z-index: 999;
        }

        .admin-page-title {
            font-size: 28px;
            font-weight: 700;
            color: #0F172A;
        }

        .admin-page-subtitle,
        .admin-breadcrumb,
        .admin-section-subtitle,
        .admin-section-breadcrumb {
            color: var(--admin-muted);
            font-size: 0.88rem;
        }

        .admin-search {
            align-items: center;
            gap: 0.6rem;
            background: #fff;
            border: 1px solid var(--admin-line);
            border-radius: 999px;
            padding: 0.55rem 1rem;
            min-width: 280px;
        }

        .admin-search i {
            color: var(--admin-muted);
        }

        .admin-search .form-control {
            border: 0;
            box-shadow: none !important;
            padding: 0;
            font-size: 0.92rem;
        }

        .admin-icon-btn {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            border: 1px solid var(--admin-line);
            background: #fff;
            color: var(--admin-text);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .admin-icon-btn:hover,
        .admin-user-btn:hover {
            color: #fff;
            background: var(--admin-primary);
            border-color: var(--admin-primary);
            transform: translateY(-2px);
        }

        .admin-notification-dot {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--admin-danger);
        }

        .admin-user-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            border: 1px solid var(--admin-line);
            border-radius: 16px;
            background: #fff;
            padding: 0.45rem 0.75rem;
            transition: all 0.3s ease;
        }

        .admin-user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: linear-gradient(135deg, #1D4ED8 0%, #60A5FA 100%);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .admin-dropdown-menu {
            border-radius: 18px;
            padding: 0.6rem;
        }

        .admin-dropdown-menu .dropdown-item {
            border-radius: 12px;
            padding: 0.75rem 0.95rem;
        }

        .admin-dropdown-menu .dropdown-item:hover {
            background: #EFF6FF;
        }

        .admin-section-header {
            margin-bottom: 1.25rem;
        }

        .admin-section-title {
            font-size: 28px;
            font-weight: 700;
            color: #0F172A;
        }

        .admin-section-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .admin-card,
        .admin-modal {
            border-radius: var(--admin-radius);
            background: var(--admin-card);
            box-shadow: var(--admin-shadow);
        }

        .admin-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .admin-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 22px 55px rgba(15, 23, 42, 0.10);
        }

        .admin-card-header {
            padding: 1.15rem 1.2rem 0;
        }

        .admin-card-body {
            padding: 1.2rem;
        }

        .admin-stat-card {
            border-radius: 22px;
            padding: 1.25rem;
            color: #fff;
            box-shadow: var(--admin-shadow);
            transition: transform 0.3s ease;
        }

        .admin-stat-card:hover {
            transform: translateY(-6px);
        }

        .admin-stat-card--primary { background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%); }
        .admin-stat-card--sky { background: linear-gradient(135deg, #38BDF8 0%, #2563EB 100%); }
        .admin-stat-card--violet { background: linear-gradient(135deg, #8B5CF6 0%, #6366F1 100%); }
        .admin-stat-card--emerald { background: linear-gradient(135deg, #10B981 0%, #059669 100%); }
        .admin-stat-card--amber { background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); }
        .admin-stat-card--slate { background: linear-gradient(135deg, #334155 0%, #0F172A 100%); }

        .admin-stat-card__title {
            font-size: 0.84rem;
            opacity: 0.88;
        }

        .admin-stat-card__value {
            font-size: 2rem;
            font-weight: 700;
            margin: 0.45rem 0 0.2rem;
        }

        .admin-stat-card__icon {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.16);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        .table-admin {
            --bs-table-bg: transparent;
            --bs-table-hover-bg: #F8FAFC;
            margin-bottom: 0;
        }

        .table-admin thead th {
            border-bottom: 1px solid var(--admin-line);
            color: var(--admin-muted);
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-weight: 600;
            padding: 0.75rem 0.85rem;
            white-space: nowrap;
        }

        .table-admin tbody td {
            padding: 0.72rem 0.85rem;
            border-color: #EEF2F7;
            vertical-align: middle;
        }

        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.28rem 0.58rem;
            border-radius: 999px;
            font-size: 0.68rem;
            font-weight: 600;
            line-height: 1.15;
        }

        .admin-badge--primary { background: #DBEAFE; color: #1D4ED8; }
        .admin-badge--warning { background: #FEF3C7; color: #B45309; }
        .admin-badge--success { background: #D1FAE5; color: #047857; }
        .admin-badge--danger { background: #FEE2E2; color: #B91C1C; }
        .admin-badge--slate { background: #E2E8F0; color: #475569; }
        .admin-badge--violet { background: #EDE9FE; color: #6D28D9; }

        .form-control,
        .form-select,
        .form-check-input {
            border-radius: 14px;
            border-color: #D7DEE7;
            min-height: 46px;
            box-shadow: none !important;
        }

        textarea.form-control {
            min-height: 110px;
        }

        .form-control:focus,
        .form-select:focus,
        .form-check-input:focus {
            border-color: rgba(37, 99, 235, 0.45);
            box-shadow: 0 0 0 0.18rem rgba(37, 99, 235, 0.10) !important;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
            border: 0;
            color: #fff;
            border-radius: 14px;
            padding: 0.75rem 1.15rem;
            font-weight: 600;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.18);
        }

        .btn-primary-custom:hover {
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-soft {
            background: #EFF6FF;
            color: #1D4ED8;
            border: 1px solid #BFDBFE;
            border-radius: 14px;
        }

        .btn-icon-clean {
            width: 44px !important;
            height: 44px !important;
            min-width: 44px;
            min-height: 44px;
            padding: 0 !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
        }

        .btn-soft:hover {
            background: #DBEAFE;
            color: #1D4ED8;
        }

        .admin-chart-box {
            position: relative;
            height: 300px;
        }

        .admin-footer {
            margin-top: 1.5rem;
            padding: 1rem 0 0.5rem;
            color: var(--admin-muted);
            font-size: 0.85rem;
        }

        .admin-empty-state {
            padding: 2.5rem 1rem;
            text-align: center;
            color: var(--admin-muted);
        }

        .table-responsive-stack {
            overflow-x: auto;
        }

        .table-mobile-label {
            display: none;
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            color: var(--admin-muted);
            margin-bottom: 0.25rem;
        }

        .admin-timeline {
            display: flex;
            justify-content: space-between;
            gap: 0.5rem;
            overflow-x: auto;
            padding-bottom: 0.25rem;
        }

        .admin-timeline__item {
            min-width: 110px;
            position: relative;
            text-align: center;
            flex: 1 1 0;
        }

        .admin-timeline__item::after {
            content: "";
            position: absolute;
            top: 16px;
            left: calc(50% + 18px);
            width: calc(100% - 36px);
            height: 3px;
            background: #D7DEE7;
            z-index: 0;
        }

        .admin-timeline__item:last-child::after {
            display: none;
        }

        .admin-timeline__dot {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #CBD5E1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
            color: #94A3B8;
            margin-bottom: 0.55rem;
        }

        .admin-timeline__item.is-done .admin-timeline__dot,
        .admin-timeline__item.is-current .admin-timeline__dot {
            border-color: var(--admin-primary);
            color: #fff;
            background: var(--admin-primary);
        }

        .admin-timeline__item.is-done::after,
        .admin-timeline__item.is-current::after {
            background: var(--admin-primary);
        }

        .admin-skeleton {
            position: relative;
            overflow: hidden;
        }

        .admin-skeleton::after {
            content: "";
            position: absolute;
            inset: 0;
            transform: translateX(-100%);
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.55), transparent);
            animation: adminShimmer 1.8s infinite;
        }

        @keyframes adminShimmer {
            100% {
                transform: translateX(100%);
            }
        }

        @media (max-width: 991.98px) {
            body {
                overflow: auto;
            }

            .admin-sidebar-shell {
                display: none;
            }

            .admin-content-shell {
                margin-left: 0;
                height: auto;
                overflow: visible;
            }

            .admin-main {
                padding: 1rem;
            }

            .admin-header {
                padding: 0.9rem 1rem;
                border-radius: 18px;
            }

            .admin-page-subtitle {
                max-width: 320px;
            }

            .admin-chart-box {
                height: 260px;
            }
        }

        @media (max-width: 767.98px) {
            .admin-main {
                padding: 0.85rem;
            }

            .admin-header {
                margin-bottom: 1rem;
                padding: 0.85rem;
            }

            .admin-page-title,
            .admin-section-title {
                font-size: 24px;
            }

            .admin-page-subtitle {
                font-size: 0.82rem;
            }

            .admin-card-header,
            .admin-card-body {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .admin-card-header {
                padding-top: 1rem;
            }

            .admin-stat-card {
                padding: 1rem;
                border-radius: 20px;
            }

            .admin-stat-card__value {
                font-size: 1.65rem;
            }

            .admin-stat-card__icon {
                width: 50px;
                height: 50px;
                border-radius: 16px;
            }

            .admin-chart-box {
                height: 220px;
            }

            .btn-icon-clean {
                width: 46px !important;
                height: 46px !important;
                min-width: 46px;
                min-height: 46px;
                border-radius: 14px;
            }

            .table-responsive-stack {
                overflow: visible;
            }

            .table-responsive-stack .table-admin,
            .table-responsive-stack .table-admin thead,
            .table-responsive-stack .table-admin tbody,
            .table-responsive-stack .table-admin tr,
            .table-responsive-stack .table-admin th,
            .table-responsive-stack .table-admin td {
                display: block;
                width: 100%;
            }

            .table-responsive-stack .table-admin thead {
                display: none;
            }

            .table-responsive-stack .table-admin tbody {
                display: grid;
                gap: 0.9rem;
            }

            .table-responsive-stack .table-admin tr {
                background: #fff;
                border: 1px solid #EEF2F7;
                border-radius: 18px;
                padding: 0.35rem 0.1rem;
                box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
            }

            .table-responsive-stack .table-admin tbody td {
                border: 0;
                padding: 0.5rem 0.9rem;
                white-space: normal;
                text-align: left !important;
            }

            .table-responsive-stack .table-admin tbody td + td {
                border-top: 1px dashed #E2E8F0;
            }

            .table-mobile-label {
                display: block;
            }

            .admin-section-actions {
                width: 100%;
            }

            .admin-section-actions .btn {
                width: 100%;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    @php
        $pageTitle = trim($__env->yieldContent('title')) ?: 'Dashboard';
        $pageSubtitle = trim($__env->yieldContent('page_subtitle'));
    @endphp

    <div class="admin-app">
        <div class="admin-sidebar-shell d-none d-lg-block">
            <x-admin.sidebar />
        </div>

        <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="adminSidebarOffcanvas" style="background:#0F172A; width: 270px;">
            <div class="offcanvas-header border-bottom border-secondary-subtle">
                <h5 class="offcanvas-title text-white mb-0">Menu Admin</h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="offcanvas" aria-label="Tutup"></button>
            </div>
            <div class="offcanvas-body p-0">
                <x-admin.sidebar />
            </div>
        </div>

        <div class="admin-content-shell">
            <main class="admin-main">
                <x-admin.header :title="$pageTitle" :subtitle="$pageSubtitle" />

                @if(session('success'))
                    <div class="d-none" data-toast-success="{{ session('success') }}"></div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm rounded-4">
                        <strong>Validasi gagal.</strong>
                        <ul class="mb-0 mt-2 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')

                <x-admin.footer />
            </main>
        </div>
    </div>

    <x-admin.confirm-modal />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const collapseToggle = document.getElementById('sidebarCollapseToggle');
            const savedSidebarState = localStorage.getItem('admin-sidebar-collapsed');

            if (savedSidebarState === 'true' && window.innerWidth >= 992) {
                document.body.classList.add('sidebar-collapsed');
            }

            if (collapseToggle) {
                collapseToggle.addEventListener('click', function () {
                    document.body.classList.toggle('sidebar-collapsed');
                    localStorage.setItem('admin-sidebar-collapsed', document.body.classList.contains('sidebar-collapsed'));
                });
            }

            const successToast = document.querySelector('[data-toast-success]');

            if (successToast) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: successToast.dataset.toastSuccess,
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                });
            }

            document.querySelectorAll('.counter').forEach(function (counter) {
                const target = Number(counter.dataset.target || 0);

                if (!target || isNaN(target)) {
                    return;
                }

                let current = 0;
                const increment = Math.max(1, Math.ceil(target / 40));
                const prefix = counter.textContent.trim().startsWith('Rp') ? 'Rp ' : '';

                const animate = () => {
                    current += increment;

                    if (current >= target) {
                        current = target;
                    }

                    counter.textContent = prefix + current.toLocaleString('id-ID');

                    if (current < target) {
                        requestAnimationFrame(animate);
                    }
                };

                counter.textContent = prefix + '0';
                requestAnimationFrame(animate);
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
