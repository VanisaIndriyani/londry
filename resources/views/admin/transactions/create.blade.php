@extends('layouts.admin')

@section('title', 'Buat Transaksi')

@section('content')
    @php
        $subtotal = $order->weight * $order->service->price;
    @endphp
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Buat Transaksi</h2>
        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card card-custom">
        <div class="card-body p-5">
            <div class="alert alert-primary border-0 rounded-4 mb-4" style="background:#eff6ff; color:#1d4ed8;">
                Transaksi dibuat setelah admin menimbang laundry secara manual. Total pembayaran otomatis mengikuti berat final pesanan.
            </div>
            <form method="POST" action="{{ route('admin.transactions.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <input type="hidden" name="customer_name" value="{{ $order->customer_name }}">
                <input type="hidden" name="total_weight" value="{{ $order->weight }}">
                <input type="hidden" name="price_per_unit" value="{{ $order->service->price }}">
                <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                
                <div class="mb-4 p-4 bg-light rounded-3">
                    <h6 class="mb-3">Detail Pesanan</h6>
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="mb-1"><strong>Nomor Pesanan:</strong> {{ $order->order_number }}</p>
                            <p class="mb-1"><strong>Nama:</strong> {{ $order->customer_name }}</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-1"><strong>Layanan:</strong> {{ $order->service->name }}</p>
                            <p class="mb-1"><strong>Total Berat:</strong> {{ number_format((float) $order->weight, 2, ',', '.') }} {{ $order->service->unit }}</p>
                            <p class="mb-1"><strong>Subtotal:</strong> <span class="text-primary fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span></p>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Metode Pembayaran</label>
                    <select name="payment_method" class="form-select" required>
                        <option value="Cash">Cash</option>
                        <option value="Transfer">Transfer</option>
                        <option value="QRIS">QRIS</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status Pembayaran</label>
                    <select name="payment_status" class="form-select" required>
                        <option value="Belum Bayar">Belum Bayar</option>
                        <option value="Lunas">Lunas</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Bayar</label>
                    <input type="date" name="payment_date" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Bukti Transfer (Opsional)</label>
                    <input type="file" name="proof_of_transfer" class="form-control" accept="image/*,.pdf">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-save me-2"></i>Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
