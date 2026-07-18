@extends('layouts.admin')

@section('title', 'Detail Pesanan')
@section('page_subtitle', 'Detail pesanan.')

@section('content')
    @php
        $timelineStatuses = ['Menunggu Konfirmasi', 'Dijemput', 'Dicuci', 'Disetrika', 'Selesai', 'Diantar'];
        $currentIndex = array_search($order->status, $timelineStatuses, true);
        $currentIndex = $currentIndex === false ? 0 : $currentIndex;
        $weightReady = (float) $order->weight > 0;
    @endphp

    <x-admin.page-header
        :title="'Detail Pesanan: ' . $order->order_number"
        subtitle="Detail pesanan."
    >
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary rounded-4 px-4">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </x-admin.page-header>

    <div class="admin-card mb-4">
        <div class="admin-card-body">
            <div class="admin-timeline">
                @foreach($timelineStatuses as $index => $status)
                    <div class="admin-timeline__item {{ $index < $currentIndex ? 'is-done' : ($index === $currentIndex ? 'is-current' : '') }}">
                        <div class="admin-timeline__dot">
                            <i class="bi {{ $index <= $currentIndex ? 'bi-check-lg' : 'bi-dot' }}"></i>
                        </div>
                        <div class="small fw-semibold">{{ $status }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="admin-card mb-4">
        <div class="admin-card-body d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
            <div>
                <div class="fw-semibold mb-1">Alur Admin</div>
                <div class="text-secondary small">Konfirmasi via WhatsApp, timbang manual, lalu isi berat final dari halaman edit pesanan.</div>
            </div>
            <div class="d-flex flex-column flex-sm-row gap-2">
                <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-primary-custom">
                    <i class="bi bi-pencil-square me-2"></i>{{ $weightReady ? 'Edit Detail & Berat' : 'Input Berat Manual' }}
                </a>
                @if(!$order->transaction && $weightReady)
                    <a href="{{ route('admin.transactions.create', ['orderId' => $order->id]) }}" class="btn btn-outline-primary rounded-4 px-4">
                        <i class="bi bi-cash-coin me-2"></i>Buat Transaksi
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="mb-0">Informasi Pelanggan</h5>
                </div>
                <div class="admin-card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Nama</th>
                            <td>{{ $order->customer_name }}</td>
                        </tr>
                        <tr>
                            <th>WhatsApp</th>
                            <td>{{ $order->customer_whatsapp }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $order->customer_address }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="mb-0">Detail Pesanan</h5>
                </div>
                <div class="admin-card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Layanan</th>
                            <td>{{ $order->service->name }}</td>
                        </tr>
                        <tr>
                            <th>Berat</th>
                            <td>{{ $weightReady ? number_format((float) $order->weight, 2, ',', '.') . ' ' . $order->service->unit : 'Belum ditimbang admin' }}</td>
                        </tr>
                        <tr>
                            <th>Harga / {{ $order->service->unit }}</th>
                            <td>Rp {{ number_format($order->service->price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Subtotal</th>
                            <td class="fw-bold">{{ $weightReady ? 'Rp ' . number_format($order->weight * $order->service->price, 0, ',', '.') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Penjemputan</th>
                            <td>{{ $order->pickup_date }} {{ $order->pickup_time }}</td>
                        </tr>
                        <tr>
                            <th>Status Laundry</th>
                            <td><span class="admin-badge admin-badge--primary">{{ $order->status }}</span></td>
                        </tr>
                        @if($order->notes)
                            <tr>
                                <th>Catatan</th>
                                <td>{{ $order->notes }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="mb-0">Update Status</h5>
                </div>
                <div class="admin-card-body">
                    <form id="statusForm">
                        @csrf
                        <div class="mb-3">
                            <select name="status" class="form-select">
                                <option value="Menunggu Konfirmasi" {{ $order->status == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                <option value="Dijemput" {{ $order->status == 'Dijemput' ? 'selected' : '' }}>Dijemput</option>
                                <option value="Dicuci" {{ $order->status == 'Dicuci' ? 'selected' : '' }}>Dicuci</option>
                                <option value="Disetrika" {{ $order->status == 'Disetrika' ? 'selected' : '' }}>Disetrika</option>
                                <option value="Selesai" {{ $order->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Diantar" {{ $order->status == 'Diantar' ? 'selected' : '' }}>Diantar</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100">
                            <i class="bi bi-check-lg me-2"></i>Update Status
                        </button>
                    </form>
                </div>
            </div>

            @if(!$order->transaction)
                <div class="admin-card">
                    <div class="admin-card-body text-center">
                        <h6 class="mb-3">Buat Transaksi</h6>
                        @if($weightReady)
                            <a href="{{ route('admin.transactions.create', ['orderId' => $order->id]) }}" class="btn btn-primary-custom w-100">
                                <i class="bi bi-cash-coin me-2"></i>Buat Transaksi
                            </a>
                            <div class="text-secondary small mt-3">Transaksi dibuat setelah berat final sudah diisi.</div>
                        @else
                            <button type="button" class="btn btn-outline-secondary w-100" disabled>
                                <i class="bi bi-lock me-2"></i>Input Berat Dulu
                            </button>
                            <div class="text-secondary small mt-3">Transaksi dikunci sampai admin mengisi berat final.</div>
                        @endif
                    </div>
                </div>
            @else
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h6 class="mb-0">Transaksi</h6>
                    </div>
                    <div class="admin-card-body text-center">
                        <span class="admin-badge {{ $order->transaction->payment_status == 'Lunas' ? 'admin-badge--success' : 'admin-badge--danger' }}">
                            {{ $order->transaction->payment_status }}
                        </span>
                        <a href="{{ route('admin.transactions.show', $order->transaction) }}" class="btn btn-outline-primary btn-sm rounded-4 w-100 mt-3">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.getElementById('statusForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        try {
            const response = await fetch('{{ route('admin.orders.update-status', $order) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Status Berhasil Diperbarui!',
                    confirmButtonText: 'OK'
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terjadi kesalahan.'
            });
        }
    });
</script>
@endsection
