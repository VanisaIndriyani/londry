@extends('layouts.admin')

@section('title', 'Laporan')
@section('page_subtitle', 'Ringkasan laporan.')

@section('content')
    <x-admin.page-header title="Laporan" subtitle="Ringkasan laporan.">
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.reports.index', ['filter' => 'day']) }}" class="btn {{ $filter == 'day' ? 'btn-primary-custom' : 'btn-outline-secondary rounded-4' }}">Hari</a>
            <a href="{{ route('admin.reports.index', ['filter' => 'week']) }}" class="btn {{ $filter == 'week' ? 'btn-primary-custom' : 'btn-outline-secondary rounded-4' }}">Minggu</a>
            <a href="{{ route('admin.reports.index', ['filter' => 'month']) }}" class="btn {{ $filter == 'month' ? 'btn-primary-custom' : 'btn-outline-secondary rounded-4' }}">Bulan</a>
            <a href="{{ route('admin.reports.index', ['filter' => 'year']) }}" class="btn {{ $filter == 'year' ? 'btn-primary-custom' : 'btn-outline-secondary rounded-4' }}">Tahun</a>
            <button class="btn btn-soft">
                <i class="bi bi-file-earmark-pdf me-2"></i>Export
            </button>
        </div>
    </x-admin.page-header>

    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <x-admin.stat-card title="Pesanan" :value="$totalOrders" icon="bi-box-seam" variant="primary" />
        </div>
        <div class="col-sm-6 col-xl-3">
            <x-admin.stat-card title="Selesai" :value="$completedOrders" icon="bi-check2-circle" variant="emerald" />
        </div>
        <div class="col-sm-6 col-xl-3">
            <x-admin.stat-card title="Pendapatan" :value="'Rp ' . number_format($totalRevenue, 0, ',', '.')" icon="bi-wallet2" variant="amber" />
        </div>
        <div class="col-sm-6 col-xl-3">
            <x-admin.stat-card title="Terlaris" :value="$mostPopularService ? $mostPopularService->name : '-'" icon="bi-trophy" variant="violet" />
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-7">
            <div class="admin-card h-100">
                <div class="admin-card-header">
                    <h5 class="mb-0">Metode Pembayaran</h5>
                </div>
                <div class="admin-card-body">
                    <div class="admin-chart-box">
                        <canvas id="paymentMethodChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="admin-card h-100">
                <div class="admin-card-header">
                    <h5 class="mb-0">Layanan</h5>
                </div>
                <div class="admin-card-body">
                    @forelse($serviceBreakdown as $service)
                        <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                            <div class="fw-semibold">{{ $service->name }}</div>
                            <span class="admin-badge admin-badge--primary">{{ $service->orders_count }}</span>
                        </div>
                    @empty
                        <div class="admin-empty-state">
                            <i class="bi bi-bar-chart fs-1 d-block mb-3 text-secondary"></i>
                            Belum ada data.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chartElement = document.getElementById('paymentMethodChart');

        if (!chartElement) {
            return;
        }

        new Chart(chartElement, {
            type: 'doughnut',
            data: {
                labels: @json(array_keys($paymentMethodSummary)),
                datasets: [{
                    data: @json(array_values($paymentMethodSummary)),
                    backgroundColor: ['#2563EB', '#10B981', '#8B5CF6'],
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
    });
</script>
@endsection
