@extends('layouts.admin')

@section('title', 'Transaksi')
@section('page_subtitle', 'Kelola transaksi.')

@section('content')
    <x-admin.page-header
        title="Transaksi"
        subtitle="Kelola transaksi."
    />

    <div class="admin-card">
        <div class="admin-card-body">
            <div class="table-responsive table-responsive-stack">
                <table class="table table-admin table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Nomor Pesanan</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Metode</th>
                            <th>Status Bayar</th>
                            <th>Tanggal</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td class="fw-semibold">
                                    <div class="table-mobile-label">Invoice</div>
                                    INV-{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="fw-semibold">
                                    <div class="table-mobile-label">Nomor Pesanan</div>
                                    {{ $transaction->order->order_number }}
                                </td>
                                <td>
                                    <div class="table-mobile-label">Customer</div>
                                    {{ $transaction->customer_name }}
                                </td>
                                <td class="fw-semibold text-primary">
                                    <div class="table-mobile-label">Total</div>
                                    Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}
                                </td>
                                <td>
                                    <div class="table-mobile-label">Metode</div>
                                    {{ $transaction->payment_method }}
                                </td>
                                <td>
                                    <div class="table-mobile-label">Status Bayar</div>
                                    <span class="admin-badge {{ $transaction->payment_status == 'Lunas' ? 'admin-badge--success' : 'admin-badge--danger' }}">
                                        {{ $transaction->payment_status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="table-mobile-label">Tanggal</div>
                                    {{ $transaction->payment_date ?? '-' }}
                                </td>
                                <td class="text-end">
                                    <div class="table-mobile-label">Aksi</div>
                                    <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn btn-soft btn-icon-clean" data-bs-toggle="tooltip" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="admin-empty-state">
                                        <i class="bi bi-credit-card fs-1 d-block mb-3 text-secondary"></i>
                                        Belum ada transaksi yang tercatat.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pt-3">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((element) => {
        new bootstrap.Tooltip(element);
    });
</script>
@endsection
