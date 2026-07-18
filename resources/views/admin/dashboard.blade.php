@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_subtitle', 'Ringkasan data laundry.')

@section('content')
    <x-admin.page-header
        title="Dashboard"
        subtitle="Ringkasan data laundry."
    >
        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary-custom">
            <i class="bi bi-plus-circle me-2"></i>Tambah Pesanan
        </a>
    </x-admin.page-header>

    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-lg-4">
            <x-admin.stat-card title="Total Pesanan" :value="$totalOrders" icon="bi-box-seam" variant="primary" />
        </div>
        <div class="col-sm-6 col-lg-4">
            <x-admin.stat-card title="Hari Ini" :value="$todayOrders" icon="bi-calendar2-check" variant="sky" />
        </div>
        <div class="col-sm-6 col-lg-4">
            <x-admin.stat-card title="Diproses" :value="$inProgressOrders" icon="bi-arrow-repeat" variant="violet" />
        </div>
        <div class="col-sm-6 col-lg-4">
            <x-admin.stat-card title="Selesai" :value="$completedOrders" icon="bi-check2-circle" variant="emerald" />
        </div>
        <div class="col-sm-6 col-lg-4">
            <x-admin.stat-card title="Pendapatan" :value="'Rp ' . number_format($monthlyRevenue, 0, ',', '.')" icon="bi-wallet2" variant="amber" />
        </div>
        <div class="col-sm-6 col-lg-4">
            <x-admin.stat-card title="Customer" :value="$activeCustomers" icon="bi-people" variant="slate" />
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-7">
            <div class="admin-card h-100">
                <div class="admin-card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Pesanan Mingguan</h5>
                </div>
                <div class="admin-card-body">
                    <div class="admin-chart-box">
                        <canvas id="weeklyOrdersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="admin-card h-100">
                <div class="admin-card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Layanan Terlaris</h5>
                </div>
                <div class="admin-card-body">
                    <div class="admin-chart-box">
                        <canvas id="popularServicesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="admin-card h-100">
                <div class="admin-card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Pendapatan Bulanan</h5>
                </div>
                <div class="admin-card-body">
                    <div class="admin-chart-box">
                        <canvas id="monthlyRevenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="admin-card h-100">
                <div class="admin-card-header">
                    <h5 class="mb-0">Layanan</h5>
                </div>
                <div class="admin-card-body">
                    @forelse($services as $service)
                        <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                            <div>
                                <div class="fw-semibold">{{ $service->name }}</div>
                                <small class="text-secondary">{{ $service->estimated_days }} hari</small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-primary">Rp {{ number_format($service->price, 0, ',', '.') }}</div>
                                <small class="text-secondary">/ {{ $service->unit }}</small>
                            </div>
                        </div>
                    @empty
                        <div class="admin-empty-state">
                            <i class="bi bi-basket2 fs-1 d-block mb-3 text-secondary"></i>
                            Belum ada layanan aktif.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Pesanan Terbaru</h5>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-soft">
                <i class="bi bi-arrow-right-circle me-2"></i>Semua
            </a>
        </div>
        <div class="admin-card-body pt-2">
            <div class="table-responsive table-responsive-stack">
                <table class="table table-admin align-middle">
                    <thead>
                        <tr>
                            <th>No Pesanan</th>
                            <th>Nama</th>
                            <th>Layanan</th>
                            <th>Status</th>
                            <th>Pembayaran</th>
                            <th>Tanggal</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            @php
                                $statusClass = match ($order->status) {
                                    'Menunggu Konfirmasi' => 'warning',
                                    'Dijemput', 'Dicuci' => 'primary',
                                    'Disetrika' => 'violet',
                                    'Selesai', 'Diantar' => 'success',
                                    default => 'slate',
                                };
                                $paymentStatus = $order->transaction?->payment_status ?? 'Belum Bayar';
                                $paymentClass = $paymentStatus === 'Lunas' ? 'success' : 'danger';
                                $statusLabel = match ($order->status) {
                                    'Menunggu Konfirmasi' => 'Menunggu',
                                    'Dijemput' => 'Diproses',
                                    default => $order->status,
                                };
                            @endphp
                            <tr>
                                <td>
                                    <div class="table-mobile-label">No Pesanan</div>
                                    <div class="fw-semibold">{{ $order->order_number }}</div>
                                </td>
                                <td>
                                    <div class="table-mobile-label">Nama</div>
                                    {{ $order->customer_name }}
                                </td>
                                <td>
                                    <div class="table-mobile-label">Layanan</div>
                                    {{ $order->service?->name ?? '-' }}
                                </td>
                                <td>
                                    <div class="table-mobile-label">Status</div>
                                    <span class="admin-badge admin-badge--{{ $statusClass }}">{{ $statusLabel }}</span>
                                </td>
                                <td>
                                    <div class="table-mobile-label">Pembayaran</div>
                                    <span class="admin-badge admin-badge--{{ $paymentClass }}">{{ $paymentStatus }}</span>
                                </td>
                                <td>
                                    <div class="table-mobile-label">Tanggal</div>
                                    {{ \Carbon\Carbon::parse($order->pickup_date)->translatedFormat('d M Y') }}
                                </td>
                                <td class="text-end">
                                    <div class="table-mobile-label">Aksi</div>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-soft btn-icon-clean" data-bs-toggle="tooltip" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="admin-empty-state">
                                        <i class="bi bi-inboxes fs-1 d-block mb-3 text-secondary"></i>
                                        Belum ada pesanan terbaru.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const weeklyCtx = document.getElementById('weeklyOrdersChart');
        const revenueCtx = document.getElementById('monthlyRevenueChart');
        const serviceCtx = document.getElementById('popularServicesChart');

        if (weeklyCtx) {
            new Chart(weeklyCtx, {
                type: 'line',
                data: {
                    labels: @json($weeklyOrderLabels),
                    datasets: [{
                        label: 'Pesanan',
                        data: @json($weeklyOrderData),
                        borderColor: '#2563EB',
                        backgroundColor: 'rgba(37, 99, 235, 0.16)',
                        tension: 0.35,
                        fill: true,
                        pointRadius: 4,
                        pointBackgroundColor: '#2563EB'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: { grid: { display: false } },
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });
        }

        if (revenueCtx) {
            new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: @json($monthlyRevenueLabels),
                    datasets: [{
                        label: 'Pendapatan',
                        data: @json($monthlyRevenueData),
                        backgroundColor: '#60A5FA',
                        borderRadius: 10,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: { grid: { display: false } },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + Number(value).toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        }

        if (serviceCtx) {
            new Chart(serviceCtx, {
                type: 'pie',
                data: {
                    labels: @json($popularServices->pluck('name')),
                    datasets: [{
                        data: @json($popularServices->pluck('orders_count')),
                        backgroundColor: ['#2563EB', '#60A5FA', '#8B5CF6', '#10B981', '#F59E0B'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
