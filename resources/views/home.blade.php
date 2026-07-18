@extends('layouts.user')

@section('title', 'FreshPress Laundry - Laundry Hari Ini, Beres Hari Ini')

@section('content')
    @php
        $heroBackground = asset('img/bg.png');
        $statuses = ['Dijemput', 'Dicuci', 'Selesai', 'Diantar'];
    @endphp

    <style>
        .hero-clean {
            position: relative;
            min-height: clamp(440px, 82vh, 640px);
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(rgba(255, 255, 255, 0.72), rgba(255, 255, 255, 0.72)), url('{{ $heroBackground }}') center/cover no-repeat;
            overflow: hidden;
            padding: 4.5rem 0;
        }

        .hero-clean .container {
            position: relative;
            z-index: 1;
        }

        .hero-title-clean {
            font-size: clamp(2.4rem, 5vw, 3.6rem);
            font-weight: 700;
            line-height: 1.18;
            color: #102a63;
        }

        .hero-description-clean {
            max-width: 680px;
            margin-inline: auto;
            color: #6b7280;
            font-size: 0.98rem;
            line-height: 1.9;
        }

        .hero-actions-clean .btn {
            min-width: 160px;
            border-radius: 10px;
            font-size: 0.92rem;
            font-weight: 600;
            padding: 0.75rem 1.15rem;
        }

        .btn-clean-primary {
            background: var(--primary);
            border: 1px solid var(--primary);
            color: #fff;
        }

        .btn-clean-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            color: #fff;
        }

        .btn-clean-outline {
            background: #fff;
            border: 1px solid #cbd5e1;
            color: #334155;
        }

        .btn-clean-outline:hover {
            background: #f8fafc;
            color: #0f172a;
        }

        .section-clean {
            padding: clamp(52px, 7vw, 72px) 0;
        }

        .feature-card {
            padding: 1.55rem;
            height: 100%;
        }

        .feature-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #e8f0ff;
            color: var(--primary);
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .feature-price {
            display: inline-flex;
            padding: 0.45rem 0.8rem;
            border-radius: 8px;
            background: var(--primary);
            color: #fff;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .split-card {
            padding: clamp(1.2rem, 3vw, 1.65rem);
            height: 100%;
        }

        .split-card h3 {
            font-size: 1.7rem;
            font-weight: 700;
            margin-bottom: 1.2rem;
        }

        .split-muted {
            color: var(--muted);
            font-size: 0.9rem;
            line-height: 1.8;
        }

        .schedule-card {
            background: #fff;
        }

        .tracking-card {
            background: #f3f6fc;
        }

        .label-clean {
            font-size: 0.72rem;
            font-weight: 500;
            color: #475569;
            margin-bottom: 0.35rem;
        }

        .tracker-box {
            margin-top: 2rem;
            background: #fff;
            border-radius: 14px;
            border: 1px solid rgba(229, 231, 235, 0.95);
            padding: 1rem;
        }

        .tracker-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            font-size: 0.78rem;
            margin-bottom: 1rem;
        }

        .status-badge {
            background: #e8f0ff;
            color: var(--primary);
            border-radius: 999px;
            padding: 0.18rem 0.55rem;
            font-size: 0.68rem;
            font-weight: 600;
        }

        .tracker-steps {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 0.25rem;
        }

        .tracker-step {
            flex: 1 1 0;
            text-align: center;
            position: relative;
        }

        .tracker-step::after {
            content: "";
            position: absolute;
            top: 10px;
            left: calc(50% + 14px);
            width: calc(100% - 28px);
            height: 3px;
            background: #dbe4f0;
            z-index: 0;
        }

        .tracker-step:last-child::after {
            display: none;
        }

        .tracker-dot {
            width: 22px;
            height: 22px;
            margin: 0 auto 0.7rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
            border: 2px solid #cbd5e1;
            background: #fff;
            color: #94a3b8;
            font-size: 0.72rem;
        }

        .tracker-step.done .tracker-dot {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .tracker-step.current .tracker-dot {
            background: #fff;
            border-color: var(--primary);
            color: var(--primary);
        }

        .tracker-step.current::after,
        .tracker-step.done::after {
            background: var(--primary);
        }

        .tracker-label {
            font-size: 0.72rem;
            color: #475569;
            font-weight: 500;
        }

        @media (max-width: 991.98px) {
            .hero-clean {
                min-height: 500px;
                padding: 4rem 0;
            }

            .hero-description-clean {
                max-width: 620px;
            }
        }

        @media (max-width: 767.98px) {
            .hero-clean {
                min-height: 420px;
                padding: 3.5rem 0;
            }

            .hero-title-clean {
                font-size: clamp(2rem, 9vw, 2.8rem);
            }

            .hero-actions-clean .btn {
                width: 100%;
            }

            .tracker-top {
                flex-direction: column;
                align-items: flex-start;
            }

            .tracker-steps {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 0.9rem 0.75rem;
                padding-bottom: 0;
            }

            .tracker-step {
                min-width: 0;
            }

            .tracker-step::after {
                display: none;
            }

            .tracker-label {
                min-height: 2rem;
            }

            .tracker-label {
                font-size: 0.64rem;
            }
        }
    </style>

    <section class="hero-clean">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-xl-8 col-lg-10">
                    <h1 class="hero-title-clean mb-4">Laundry Hari Ini, Beres Hari Ini</h1>
                    <p class="hero-description-clean mb-4">
                        Percayakan pakaian Anda pada layanan cuci profesional yang mengutamakan kebersihan, kecepatan, dan kualitas. Sistem Hydro-Clean kami menjamin kesegaran setiap serat kain.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-3 hero-actions-clean">
                        <a href="#pickup" class="btn btn-clean-primary">
                            Pesan Sekarang
                        </a>
                        <a href="#services" class="btn btn-clean-outline">
                            Lihat Layanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-clean" id="services">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title-clean">Layanan Unggulan Kami</h2>
                <p class="section-subtitle-clean">
                    Solusi lengkap untuk segala kebutuhan perawatan pakaian Anda dengan standar kebersihan tertinggi.
                </p>
            </div>
            <div class="row g-4">
                @foreach($services->take(3) as $service)
                    @php
                        $serviceIcon = match (true) {
                            str_contains(strtolower($service->name), 'setrika') => 'bi-basket2',
                            str_contains(strtolower($service->name), 'dry') => 'bi-person',
                            default => 'bi-bag'
                        };
                    @endphp
                    <div class="col-md-6 col-xl-4">
                        <div class="card-clean feature-card">
                            <div class="feature-icon">
                                <i class="bi {{ $serviceIcon }}"></i>
                            </div>
                            <h4 class="mb-2" style="font-size: 1.7rem; color: #111827;">{{ $service->name }}</h4>
                            <p class="text-secondary mb-3" style="font-size: 0.92rem; line-height: 1.8;">
                                {{ $service->description ?: 'Layanan praktis untuk pakaian harian Anda. Bersih, wangi, dan rapi terlipat.' }}
                            </p>
                            <span class="feature-price">Mulai Rp {{ number_format($service->price, 0, ',', '.') }}/{{ $service->unit }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-clean pt-0">
        <div class="container">
            <div class="row g-4">
                <div class="col-xl-6" id="pickup">
                    <div class="card-clean split-card schedule-card">
                        <h3>Jadwalkan Penjemputan</h3>
                        <form id="homeOrderForm">
                            @csrf
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="label-clean">Nama Lengkap</label>
                                    <input type="text" name="customer_name" class="form-control input-clean" placeholder="Masukkan nama Anda" required>
                                </div>
                                <div class="col-sm-6">
                                    <label class="label-clean">Nomor WhatsApp</label>
                                    <input type="text" name="customer_whatsapp" class="form-control input-clean" placeholder="08xx-xxxx-xxxx" required>
                                </div>
                                <div class="col-12">
                                    <label class="label-clean">Alamat Penjemputan</label>
                                    <textarea name="customer_address" class="form-control textarea-clean" rows="3" placeholder="Detail alamat lengkap..." required></textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label class="label-clean">Jenis Layanan</label>
                                    <select name="service_id" id="serviceSelectHome" class="form-select select-clean" required>
                                            <option value="">Cuci & Lipat (Kiloan)</option>
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}" data-unit="{{ $service->unit }}">
                                                    {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}/{{ $service->unit }}
                                                </option>
                                            @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="label-clean">Tanggal Penjemputan</label>
                                    <input type="date" name="pickup_date" class="form-control input-clean" min="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-sm-6">
                                    <label class="label-clean">Waktu Penjemputan</label>
                                    <input type="time" name="pickup_time" class="form-control input-clean" required>
                                </div>
                                <div class="col-12">
                                    <label class="label-clean">Catatan</label>
                                    <textarea name="notes" class="form-control textarea-clean" rows="2" placeholder="Catatan tambahan (opsional)"></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" id="submitHomeOrder" class="btn btn-clean-primary w-100 py-2">
                                        <i class="bi bi-truck me-2"></i>Pesan Penjemputan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-6" id="tracking">
                    <div class="card-clean split-card tracking-card">
                        <h3>Cek Status Pesanan</h3>
                        <p class="split-muted mb-4">
                            Masukkan ID Pesanan Anda untuk melihat progress cucian secara real-time.
                        </p>
                        <form method="GET" action="{{ route('check-status') }}">
                            <div class="input-group">
                                <input type="text" name="order_number" class="form-control input-clean" placeholder="Contoh: LDR-202607180001" required>
                                <button type="submit" class="btn btn-secondary" style="background:#6b7280;border-color:#6b7280;border-radius:10px;">
                                    <i class="bi bi-search"></i>
                                    <span class="ms-1">Lacak</span>
                                </button>
                            </div>
                        </form>

                        <div class="tracker-box">
                            <div class="tracker-top">
                                <div><strong>Pesanan:</strong> LDR-202607180001</div>
                                <span class="status-badge">Aktif</span>
                            </div>
                            <div class="tracker-steps">
                            @foreach($statuses as $index => $status)
                                <div class="tracker-step {{ $index < 2 ? 'done' : ($index === 2 ? 'current' : '') }}">
                                    <div class="tracker-dot">
                                        @if($index < 2)
                                            <i class="bi bi-check-lg"></i>
                                        @elseif($index === 2)
                                            <i class="bi bi-record-circle"></i>
                                        @endif
                                    </div>
                                    <div class="tracker-label">{{ $status }}</div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const homeOrderForm = document.getElementById('homeOrderForm');
        const submitHomeOrder = document.getElementById('submitHomeOrder');

        if (homeOrderForm) {
            homeOrderForm.addEventListener('submit', async function (event) {
                event.preventDefault();

                const originalButton = submitHomeOrder.innerHTML;
                submitHomeOrder.disabled = true;
                submitHomeOrder.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';

                try {
                    const response = await fetch('{{ route('order.store') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: new FormData(homeOrderForm)
                    });

                    const data = await response.json();

                    if (! response.ok) {
                        const messages = data.errors
                            ? Object.values(data.errors).flat().join('<br>')
                            : 'Terjadi kesalahan saat mengirim pesanan.';

                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            html: messages
                        });

                        return;
                    }

                    await Swal.fire({
                        icon: 'success',
                        title: 'Pesanan berhasil dibuat.',
                        html: 'Nomor Pesanan Anda:<br><strong>' + data.order_number + '</strong><br><br>Silakan simpan nomor ini untuk mengecek status laundry.',
                        confirmButtonText: 'Buka WhatsApp',
                        confirmButtonColor: '#2563EB'
                    });

                    window.open(data.whatsapp_url, '_blank');
                    homeOrderForm.reset();
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan, silakan coba lagi.'
                    });
                } finally {
                    submitHomeOrder.disabled = false;
                    submitHomeOrder.innerHTML = originalButton;
                }
            });
        }
    });
</script>
@endsection
