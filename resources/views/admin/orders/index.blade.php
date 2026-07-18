@extends('layouts.admin')

@section('title', 'Pesanan')
@section('page_subtitle', 'Kelola pesanan customer.')

@section('content')
    <x-admin.page-header
        title="Pesanan"
        subtitle="Kelola pesanan customer."
    >
        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary-custom">
            <i class="bi bi-plus-lg me-2"></i>Tambah
        </a>
    </x-admin.page-header>

    <div class="admin-card mb-4">
        <div class="admin-card-body">
            <form method="GET" action="{{ route('admin.orders.index') }}">
                <div class="row g-2 g-lg-3">
                    <div class="col-12 col-md-6 col-lg-4">
                        <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
                    </div>
                    <div class="col-12 col-md-6 col-lg-2">
                        <select name="status" class="form-select">
                            <option value="">Status</option>
                            <option value="Menunggu Konfirmasi" {{ request('status') == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Dijemput" {{ request('status') == 'Dijemput' ? 'selected' : '' }}>Diproses</option>
                            <option value="Dicuci" {{ request('status') == 'Dicuci' ? 'selected' : '' }}>Dicuci</option>
                            <option value="Disetrika" {{ request('status') == 'Disetrika' ? 'selected' : '' }}>Disetrika</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Diantar" {{ request('status') == 'Diantar' ? 'selected' : '' }}>Diantar</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-6 col-lg-2">
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="Tanggal Awal">
                    </div>
                    <div class="col-6 col-md-6 col-lg-2">
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="Tanggal Akhir">
                    </div>
                    <div class="col-12 col-md-12 col-lg-2">
                        <button type="submit" class="btn btn-primary-custom w-100">
                            <i class="bi bi-search me-2"></i>Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-body">
            <div class="table-responsive table-responsive-stack">
                <table class="table table-admin table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Nomor Pesanan</th>
                            <th>Nama</th>
                            <th>WhatsApp</th>
                            <th>Alamat</th>
                            <th>Layanan</th>
                            <th>Berat</th>
                            <th>Total</th>
                            <th>Tanggal</th>
                            <th>Status Laundry</th>
                            <th>Status Bayar</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
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
                                $weightLabel = (float) $order->weight > 0
                                    ? number_format((float) $order->weight, 2, ',', '.') . ' ' . ($order->service?->unit ?? 'kg')
                                    : 'Belum ditimbang';
                            @endphp
                            <tr>
                                <td class="fw-semibold">
                                    <div class="table-mobile-label">Nomor Pesanan</div>
                                    {{ $order->order_number }}
                                </td>
                                <td>
                                    <div class="table-mobile-label">Nama</div>
                                    {{ $order->customer_name }}
                                </td>
                                <td>
                                    <div class="table-mobile-label">WhatsApp</div>
                                    {{ $order->customer_whatsapp }}
                                </td>
                                <td class="text-truncate" style="max-width: 220px;">
                                    <div class="table-mobile-label">Alamat</div>
                                    {{ \Illuminate\Support\Str::limit($order->customer_address, 42) }}
                                </td>
                                <td>
                                    <div class="table-mobile-label">Layanan</div>
                                    {{ $order->service?->name ?? '-' }}
                                </td>
                                <td>
                                    <div class="table-mobile-label">Berat</div>
                                    {{ $weightLabel }}
                                </td>
                                <td class="fw-semibold text-primary">
                                    <div class="table-mobile-label">Total</div>
                                    {{ (float) $order->weight > 0 ? 'Rp ' . number_format(($order->weight ?? 0) * ($order->service?->price ?? 0), 0, ',', '.') : '-' }}
                                </td>
                                <td>
                                    <div class="table-mobile-label">Tanggal</div>
                                    {{ \Carbon\Carbon::parse($order->pickup_date)->translatedFormat('d M Y') }}
                                </td>
                                <td>
                                    <div class="table-mobile-label">Status Laundry</div>
                                    <span class="admin-badge admin-badge--{{ $statusClass }}">{{ $statusLabel }}</span>
                                </td>
                                <td>
                                    <div class="table-mobile-label">Status Bayar</div>
                                    <span class="admin-badge admin-badge--{{ $paymentClass }}">{{ $paymentStatus }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="table-mobile-label">Aksi</div>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-soft btn-icon-clean me-1" data-bs-toggle="tooltip" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-outline-secondary btn-icon-clean me-1" data-bs-toggle="tooltip" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button class="btn btn-outline-danger btn-icon-clean" onclick="deleteOrder({{ $order->id }})" data-bs-toggle="tooltip" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">
                                    <div class="admin-empty-state">
                                        <i class="bi bi-inboxes fs-1 d-block mb-3 text-secondary"></i>
                                        Belum ada data pesanan yang cocok dengan filter.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((element) => {
        new bootstrap.Tooltip(element);
    });

    function deleteOrder(id) {
        Swal.fire({
            title: 'Yakin?',
            text: 'Pesanan ini akan dihapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/orders/${id}`;
                form.innerHTML = '@csrf @method('DELETE')';
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@endsection
