@extends('layouts.admin')

@section('title', 'Detail Transaksi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail Transaksi</h2>
        <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card card-custom">
        <div class="card-body p-5">
            <h6 class="mb-4">Informasi Transaksi</h6>
            <table class="table table-borderless">
                <tr>
                    <th width="200">Nomor Pesanan</th>
                    <td>{{ $transaction->order->order_number }}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $transaction->customer_name }}</td>
                </tr>
                <tr>
                    <th>Total Berat</th>
                    <td>{{ $transaction->total_weight }} {{ $transaction->order->service->unit }}</td>
                </tr>
                <tr>
                    <th>Harga / {{ $transaction->order->service->unit }}</th>
                    <td>Rp {{ number_format($transaction->price_per_unit, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Subtotal</th>
                    <td class="fw-bold text-primary">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Metode Pembayaran</th>
                    <td>{{ $transaction->payment_method }}</td>
                </tr>
                <tr>
                    <th>Status Pembayaran</th>
                    <td>
                        <span class="badge {{ $transaction->payment_status == 'Lunas' ? 'bg-success' : 'bg-warning' }}">
                            {{ $transaction->payment_status }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Tanggal Bayar</th>
                    <td>{{ $transaction->payment_date ?? '-' }}</td>
                </tr>
                @if($transaction->proof_of_transfer)
                    <tr>
                        <th>Bukti Transfer</th>
                        <td><a href="{{ asset('storage/' . $transaction->proof_of_transfer) }}" target="_blank">Lihat Bukti</a></td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection
