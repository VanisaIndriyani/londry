<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FreshPress Laundry')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #2563EB;
            --primary-dark: #1d4ed8;
            --secondary: #eaf1ff;
            --background: #f5f7fb;
            --surface: #ffffff;
            --muted: #6b7280;
            --text: #1f2937;
            --line: #e5e7eb;
            --success: #22c55e;
            --radius-lg: 18px;
            --radius-md: 14px;
            --shadow-soft: 0 12px 30px rgba(15, 23, 42, 0.06);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--background);
            color: var(--text);
        }

        a {
            text-decoration: none;
        }

        .site-navbar {
            position: sticky;
            top: 0;
            z-index: 1030;
            background: rgba(255, 255, 255, 0.92);
            border-bottom: 1px solid rgba(229, 231, 235, 0.8);
            backdrop-filter: blur(14px);
        }

        .navbar-brand-clean {
            color: var(--primary);
            font-size: 1.25rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            min-width: 0;
        }

        .brand-name-clean {
            max-width: 220px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .brand-logo-clean {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: #eef4ff;
            border: 1px solid rgba(37, 99, 235, 0.10);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex: 0 0 42px;
        }

        .brand-logo-clean img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .brand-logo-clean i {
            font-size: 1.15rem;
            color: var(--primary);
        }

        .navbar-nav .nav-link {
            color: var(--text);
            font-size: 0.92rem;
            font-weight: 500;
            padding: 1.25rem 0.95rem;
            position: relative;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary);
        }

        .navbar-nav .nav-link.active::after {
            content: "";
            position: absolute;
            left: 0.95rem;
            right: 0.95rem;
            bottom: 0.85rem;
            height: 2px;
            background: var(--primary);
            border-radius: 999px;
        }

        .btn-user-outline {
            border: 1px solid transparent;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.88rem;
            padding: 0.6rem 1rem;
            border-radius: 10px;
            background: transparent;
        }

        .btn-user-primary {
            border: 0;
            color: #fff;
            font-weight: 600;
            font-size: 0.88rem;
            padding: 0.65rem 1.1rem;
            border-radius: 10px;
            background: var(--primary);
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.18);
        }

        .btn-user-primary:hover,
        .btn-user-outline:hover {
            color: #fff;
            background: var(--primary-dark);
        }

        .section-title-clean {
            font-size: clamp(2rem, 3.4vw, 2.8rem);
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.9rem;
        }

        .section-subtitle-clean {
            max-width: 640px;
            margin-inline: auto;
            color: var(--muted);
            font-size: 0.98rem;
            line-height: 1.8;
        }

        .card-clean {
            background: var(--surface);
            border: 1px solid rgba(229, 231, 235, 0.9);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-soft);
        }

        .input-clean,
        .select-clean,
        .textarea-clean {
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 0.92rem;
            min-height: 44px;
        }

        .input-clean:focus,
        .select-clean:focus,
        .textarea-clean:focus {
            border-color: rgba(37, 99, 235, 0.5);
            box-shadow: 0 0 0 0.18rem rgba(37, 99, 235, 0.12);
        }

        .page-footer {
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.08), transparent 32%),
                linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            border-top: 1px solid rgba(229, 231, 235, 0.85);
        }

        .footer-shell {
            padding: 2rem;
            border: 1px solid rgba(229, 231, 235, 0.9);
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.92);
            box-shadow: 0 22px 55px rgba(15, 23, 42, 0.06);
            backdrop-filter: blur(10px);
        }

        .footer-brand-card {
            padding: 1.4rem;
            border-radius: 22px;
            background: linear-gradient(145deg, #ffffff 0%, #eef4ff 100%);
            border: 1px solid rgba(37, 99, 235, 0.12);
            height: 100%;
        }

        .footer-title {
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #111827;
        }

        .footer-description {
            max-width: 340px;
            color: var(--muted);
            line-height: 1.8;
            font-size: 0.92rem;
            margin-bottom: 0;
        }

        .footer-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.55rem 0.9rem;
            border-radius: 999px;
            background: #eff6ff;
            color: var(--primary);
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .footer-link {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            color: var(--muted);
            font-size: 0.9rem;
            margin-bottom: 0.8rem;
            transition: 0.3s ease;
        }

        .footer-link:hover {
            color: var(--primary);
            transform: translateX(4px);
        }

        .footer-link i,
        .footer-meta i {
            width: 18px;
            color: var(--primary);
        }

        .footer-meta {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            color: var(--muted);
            font-size: 0.9rem;
            line-height: 1.8;
            margin-bottom: 0.9rem;
        }

        .footer-socials {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 1.25rem;
        }

        .footer-social {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            border: 1px solid rgba(37, 99, 235, 0.10);
            color: var(--primary);
            transition: 0.3s ease;
        }

        .footer-social:hover {
            background: var(--primary);
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 14px 26px rgba(37, 99, 235, 0.18);
        }

        .footer-bottom {
            margin-top: 2rem;
            padding-top: 1.4rem;
            border-top: 1px solid rgba(229, 231, 235, 0.8);
        }

        .footer-bottom-note {
            color: var(--muted);
            font-size: 0.88rem;
        }

        .footer-bottom-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.45rem 0.75rem;
            border-radius: 999px;
            background: #f8fafc;
            color: #475569;
            font-size: 0.8rem;
            font-weight: 500;
        }

        @media (max-width: 991.98px) {
            .navbar-collapse {
                padding: 1rem;
                margin-top: 0.85rem;
                border: 1px solid rgba(229, 231, 235, 0.9);
                border-radius: 18px;
                background: rgba(255, 255, 255, 0.96);
                box-shadow: 0 18px 34px rgba(15, 23, 42, 0.08);
            }

            .navbar-nav .nav-link {
                padding: 0.75rem 0;
            }

            .navbar-nav .nav-link.active::after {
                left: 0;
                right: auto;
                width: 60px;
                bottom: 0.35rem;
            }

            .navbar-actions {
                margin-top: 0.5rem;
                width: 100%;
                flex-direction: column;
                align-items: stretch !important;
            }

            .navbar-actions .btn {
                width: 100%;
            }

            .footer-shell {
                padding: 1.5rem;
                border-radius: 24px;
            }
        }

        @media (max-width: 575.98px) {
            .navbar-brand-clean {
                font-size: 1rem;
                gap: 0.6rem;
            }

            .brand-logo-clean {
                width: 38px;
                height: 38px;
                border-radius: 12px;
                flex-basis: 38px;
            }

            .brand-name-clean {
                max-width: 150px;
            }

            .footer-shell {
                padding: 1.2rem;
            }

            .footer-brand-card {
                padding: 1.1rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    @php
        $isHomeRoute = request()->routeIs('home');
        $isCheckStatusRoute = request()->routeIs('check-status');
    @endphp
    <nav class="navbar navbar-expand-lg site-navbar">
        <div class="container">
            <a class="navbar-brand navbar-brand-clean" href="{{ route('home') }}">
                <span class="brand-logo-clean">
                    @if(!empty($appSettings['logo']))
                        <img src="{{ \App\Support\AdminSettings::logoUrl($appSettings['logo']) }}" alt="Logo Laundry">
                    @else
                        <i class="bi bi-droplet-half"></i>
                    @endif
                </span>
                <span class="brand-name-clean">{{ $appSettings['laundry_name'] ?? 'FreshPress Laundry' }}</span>
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUser" aria-label="Buka menu navigasi">
                <i class="bi bi-list fs-2 text-primary"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarUser">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ $isHomeRoute ? 'active' : '' }}" href="{{ route('home') }}" data-nav-key="beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#services" data-nav-key="layanan">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#pickup" data-nav-key="pesan">Pesan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isCheckStatusRoute ? 'active' : '' }}" href="{{ route('check-status') }}" data-nav-key="cek-status">Cek Status</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-2 navbar-actions">
                    <a href="{{ route('login') }}" class="btn btn-user-outline">Masuk Admin</a>
                    <a href="{{ route('home') }}#pickup" class="btn btn-user-primary">Pesan Sekarang</a>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="page-footer py-5">
        @php
            $instagramHandle = !empty($appSettings['instagram']) ? ltrim(str_replace(' ', '', $appSettings['instagram']), '@') : null;
            $facebookHandle = !empty($appSettings['facebook']) ? str_replace(' ', '', $appSettings['facebook']) : null;
            $instagramUrl = $instagramHandle ? 'https://instagram.com/' . $instagramHandle : null;
            $facebookUrl = $facebookHandle ? 'https://facebook.com/' . $facebookHandle : null;
        @endphp
        <div class="container">
            <div class="footer-shell">
                <div class="row g-4 g-lg-5">
                    <div class="col-lg-5">
                        <div class="footer-brand-card">
                            <div class="footer-pill">
                                <i class="bi bi-stars"></i>
                                Laundry Premium Samarinda
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <span class="brand-logo-clean">
                                    @if(!empty($appSettings['logo']))
                                        <img src="{{ \App\Support\AdminSettings::logoUrl($appSettings['logo']) }}" alt="Logo Laundry">
                                    @else
                                        <i class="bi bi-droplet-half"></i>
                                    @endif
                                </span>
                                <div class="footer-title mb-0 fs-5">{{ $appSettings['laundry_name'] ?? 'FreshPress Laundry' }}</div>
                            </div>
                            <p class="footer-description">
                                Layanan laundry modern untuk kebutuhan harian Anda, dengan proses cepat, hasil rapi, dan pelayanan yang nyaman.
                            </p>

                            <div class="footer-socials">
                                <a href="https://wa.me/{{ \App\Support\AdminSettings::waMeNumber($appSettings['whatsapp'] ?? '') }}" target="_blank" class="footer-social" aria-label="WhatsApp">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                                <a href="{{ $instagramUrl ?? '#' }}" target="_blank" class="footer-social" aria-label="Instagram">
                                    <i class="bi bi-instagram"></i>
                                </a>
                                <a href="{{ $facebookUrl ?? '#' }}" target="_blank" class="footer-social" aria-label="Facebook">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                <a href="mailto:{{ $appSettings['email'] ?? 'hello@freshpress.id' }}" class="footer-social" aria-label="Email">
                                    <i class="bi bi-envelope"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-2">
                        <div class="footer-title">Menu</div>
                        <a href="{{ route('home') }}" class="footer-link"><i class="bi bi-house-door"></i>Beranda</a>
                        <a href="{{ route('home') }}#services" class="footer-link"><i class="bi bi-grid"></i>Layanan</a>
                        <a href="{{ route('home') }}#pickup" class="footer-link"><i class="bi bi-bag-check"></i>Pesan</a>
                        <a href="{{ route('check-status') }}" class="footer-link"><i class="bi bi-search"></i>Cek Status</a>
                    </div>

                    <div class="col-6 col-lg-2">
                        <div class="footer-title">Kontak</div>
                        <a href="https://wa.me/{{ \App\Support\AdminSettings::waMeNumber($appSettings['whatsapp'] ?? '') }}" target="_blank" class="footer-link">
                            <i class="bi bi-telephone"></i>{{ $appSettings['whatsapp'] ?? '+62 812 3456 7890' }}
                        </a>
                        <a href="mailto:{{ $appSettings['email'] ?? 'hello@freshpress.id' }}" class="footer-link">
                            <i class="bi bi-envelope"></i>{{ $appSettings['email'] ?? 'hello@freshpress.id' }}
                        </a>
                    </div>

                    <div class="col-lg-3">
                        <div class="footer-title">Info Laundry</div>
                        <div class="footer-meta">
                            <i class="bi bi-geo-alt"></i>
                            <span>{{ $appSettings['address'] ?? 'Samarinda, Kalimantan Timur' }}</span>
                        </div>
                        <div class="footer-meta">
                            <i class="bi bi-clock"></i>
                            <span>{{ $appSettings['operational_hours'] ?? '08.00 - 21.00' }}</span>
                        </div>
                        @if(!empty($appSettings['instagram']))
                            <a href="{{ $instagramUrl }}" target="_blank" class="footer-link">
                                <i class="bi bi-instagram"></i>{{ $appSettings['instagram'] }}
                            </a>
                        @endif
                        @if(!empty($appSettings['facebook']))
                            <a href="{{ $facebookUrl }}" target="_blank" class="footer-link">
                                <i class="bi bi-facebook"></i>{{ $appSettings['facebook'] }}
                            </a>
                        @endif
                    </div>
                </div>

                <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div class="footer-bottom-note">
                        &copy; {{ date('Y') }} {{ $appSettings['laundry_name'] ?? 'FreshPress Laundry' }}. Semua hak dilindungi.
                    </div>
                    <div class="footer-bottom-badge">
                        <i class="bi bi-patch-check"></i>
                        Clean, Fast, Reliable
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const navLinks = document.querySelectorAll('[data-nav-key]');
            const currentPath = window.location.pathname.replace(/\/+$/, '') || '/';

            const setActiveNav = (activeKey) => {
                navLinks.forEach((link) => {
                    link.classList.toggle('active', link.dataset.navKey === activeKey);
                });
            };

            const updateActiveFromLocation = () => {
                if (currentPath.endsWith('/check-status')) {
                    setActiveNav('cek-status');
                    return;
                }

                if (!currentPath.endsWith('/') && !currentPath.endsWith('/public') && !currentPath.endsWith('/public/')) {
                    return;
                }

                const hash = window.location.hash;

                if (hash === '#services') {
                    setActiveNav('layanan');
                } else if (hash === '#pickup') {
                    setActiveNav('pesan');
                } else {
                    setActiveNav('beranda');
                }
            };

            navLinks.forEach((link) => {
                link.addEventListener('click', function () {
                    setActiveNav(this.dataset.navKey);
                });
            });

            window.addEventListener('hashchange', updateActiveFromLocation);
            updateActiveFromLocation();
        });
    </script>
    @yield('scripts')
</body>
</html>
