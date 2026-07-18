@extends('layouts.user')

@section('title', 'Cek Status Laundry')

@section('content')
    @php
        $statuses = ['Menunggu Konfirmasi', 'Dijemput', 'Dicuci', 'Disetrika', 'Selesai', 'Diantar'];
        $currentIndex = $order ? array_search($order->status, $statuses, true) : false;
        $currentIndex = $currentIndex === false ? 0 : $currentIndex;
        $progressWidth = $order && count($statuses) > 1 ? ($currentIndex / (count($statuses) - 1)) * 100 : 0;
        $progressCssWidth = $progressWidth > 0 ? "calc({$progressWidth}% - 18px)" : '0px';
        $statusLabel = $order ? match ($order->status) {
            'Menunggu Konfirmasi' => 'Menunggu Konfirmasi',
            'Dijemput' => 'Sedang Dijemput',
            'Dicuci' => 'Sedang Dicuci',
            'Disetrika' => 'Sedang Disetrika',
            'Selesai' => 'Laundry Selesai',
            'Diantar' => 'Sedang Diantar',
            default => $order->status,
        } : null;
    @endphp

    <style>
        .status-page {
            padding: 72px 0;
        }

        .status-shell {
            max-width: 1080px;
            margin: 0 auto;
        }

        .status-hero-card,
        .status-search-card,
        .status-summary-card,
        .status-timeline-card,
        .status-empty-card {
            background: #fff;
            border: 1px solid rgba(229, 231, 235, 0.95);
            border-radius: 24px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.06);
        }

        .status-hero-card {
            padding: 2rem;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.08), rgba(255, 255, 255, 0.95));
        }

        .status-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .status-heading {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            line-height: 1.14;
            color: #0f172a;
        }

        .status-description {
            max-width: 700px;
            color: #64748b;
            line-height: 1.8;
        }

        .status-search-card {
            padding: 1.3rem;
            margin-top: 1.5rem;
        }

        .status-search-input {
            min-height: 54px;
            border-radius: 16px;
            border: 1px solid #dbe3ef;
            box-shadow: none !important;
        }

        .status-search-input:focus {
            border-color: rgba(37, 99, 235, 0.5);
            box-shadow: 0 0 0 0.18rem rgba(37, 99, 235, 0.10) !important;
        }

        .status-search-btn {
            min-height: 54px;
            border-radius: 16px;
            border: 0;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #fff;
            font-weight: 600;
            padding: 0 1.4rem;
        }

        .status-search-btn:hover {
            color: #fff;
        }

        .status-badge-clean {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .status-summary-card,
        .status-timeline-card,
        .status-empty-card {
            padding: 1.6rem;
        }

        .status-meta-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
        }

        .status-meta-item {
            padding: 1rem 1.1rem;
            border-radius: 18px;
            background: #f8fafc;
            border: 1px solid #edf2f7;
        }

        .status-meta-label {
            font-size: 0.74rem;
            color: #64748b;
            margin-bottom: 0.45rem;
        }

        .status-meta-value {
            color: #0f172a;
            font-weight: 600;
        }

        .status-progress-wrap {
            position: relative;
            margin: 1.5rem 0 0.75rem;
        }

        .status-progress-line {
            position: absolute;
            top: 18px;
            left: 18px;
            right: 18px;
            height: 4px;
            border-radius: 999px;
            background: #e2e8f0;
        }

        .status-progress-line-active {
            position: absolute;
            top: 18px;
            left: 18px;
            height: 4px;
            border-radius: 999px;
            background: linear-gradient(90deg, #2563eb 0%, #60a5fa 100%);
            width: {{ $progressCssWidth }};
        }

        .status-steps {
            position: relative;
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 0.75rem;
        }

        .status-step {
            text-align: center;
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .status-step-dot {
            width: 36px;
            height: 36px;
            margin: 0 auto 0.8rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border: 2px solid #cbd5e1;
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .status-step.done .status-step-dot {
            border-color: #2563eb;
            background: #2563eb;
            color: #fff;
        }

        .status-step.current .status-step-dot {
            border-color: #2563eb;
            color: #2563eb;
            background: #eff6ff;
        }

        .status-step-label {
            font-size: 0.78rem;
            color: #475569;
            line-height: 1.5;
            font-weight: 500;
            min-height: 2.4rem;
        }

        .status-empty-card {
            text-align: center;
        }

        .status-empty-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 1rem;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fef2f2;
            color: #dc2626;
            font-size: 1.5rem;
        }

        @media (max-width: 991.98px) {
            .status-meta-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .status-steps {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                row-gap: 1.25rem;
            }

            .status-progress-line,
            .status-progress-line-active {
                display: none;
            }
        }

        @media (max-width: 575.98px) {
            .status-page {
                padding: 48px 0;
            }

            .status-hero-card,
            .status-search-card,
            .status-summary-card,
            .status-timeline-card,
            .status-empty-card {
                border-radius: 20px;
            }

            .status-steps {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .status-meta-grid {
                grid-template-columns: 1fr;
            }

            .status-step-label {
                min-height: 2.8rem;
                font-size: 0.74rem;
                line-height: 1.35;
            }
        }
    </style>

    <section class="status-page">
        <div class="container">
            <div class="status-shell">
                <div class="status-hero-card">
                    <span class="status-kicker mb-3">
                        <i class="bi bi-search-heart"></i>
                        Cek Status Laundry
                    </span>
                    <h1 class="status-heading mb-3">Pantau Proses Laundry Dengan Mudah</h1>
                    <p class="status-description mb-0">
                        Masukkan nomor pesanan untuk melihat progres laundry Anda secara real-time, mulai dari konfirmasi admin sampai pengantaran.
                    </p>
                </div>

                <div class="status-search-card">
                    <form method="GET" action="{{ route('check-status') }}">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-8 col-lg-9">
                                <input
                                    type="text"
                                    name="order_number"
                                    class="form-control status-search-input"
                                    placeholder="Masukkan nomor pesanan, contoh: LDR-202607180002"
                                    required
                                    value="{{ request('order_number') }}"
                                >
                            </div>
                            <div class="col-md-4 col-lg-3 d-grid">
                                <button class="status-search-btn" type="submit">
                                    <i class="bi bi-search me-2"></i>Cek Status
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                @if(request('order_number'))
                    @if($order)
                        <div class="status-summary-card mt-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                                <div>
                                    <div class="text-secondary small mb-2">Nomor Pesanan</div>
                                    <h3 class="mb-0">{{ $order->order_number }}</h3>
                                </div>
                                <span class="status-badge-clean">
                                    <i class="bi bi-stars"></i>
                                    {{ $statusLabel }}
                                </span>
                            </div>

                            <div class="status-meta-grid">
                                <div class="status-meta-item">
                                    <div class="status-meta-label">Nama Customer</div>
                                    <div class="status-meta-value">{{ $order->customer_name }}</div>
                                </div>
                                <div class="status-meta-item">
                                    <div class="status-meta-label">Layanan</div>
                                    <div class="status-meta-value">{{ $order->service->name }}</div>
                                </div>
                                <div class="status-meta-item">
                                    <div class="status-meta-label">Tanggal Pickup</div>
                                    <div class="status-meta-value">
                                        {{ \Carbon\Carbon::parse($order->pickup_date)->translatedFormat('d M Y') }} · {{ $order->pickup_time }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="status-timeline-card mt-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
                                <div>
                                    <h4 class="mb-1">Timeline Proses</h4>
                                    <div class="text-secondary small">Status laundry Anda diperbarui langsung oleh admin.</div>
                                </div>
                                <div class="text-secondary small">Progress {{ $currentIndex + 1 }}/{{ count($statuses) }}</div>
                            </div>

                            <div class="status-progress-wrap">
                                <div class="status-progress-line"></div>
                                <div class="status-progress-line-active"></div>

                                <div class="status-steps">
                                    @foreach($statuses as $index => $status)
                                        <div class="status-step {{ $index < $currentIndex ? 'done' : ($index === $currentIndex ? 'current' : '') }}">
                                            <div class="status-step-dot">
                                                @if($index < $currentIndex)
                                                    <i class="bi bi-check-lg"></i>
                                                @elseif($index === $currentIndex)
                                                    <i class="bi bi-record-circle"></i>
                                                @else
                                                    <i class="bi bi-dot"></i>
                                                @endif
                                            </div>
                                            <div class="status-step-label">{{ $status }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="status-empty-card mt-4">
                            <div class="status-empty-icon">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                            <h4 class="mb-2">Nomor Pesanan Tidak Ditemukan</h4>
                            <p class="text-secondary mb-0">
                                Pastikan nomor pesanan yang Anda masukkan benar, lalu coba cek kembali.
                            </p>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </section>
@endsection
