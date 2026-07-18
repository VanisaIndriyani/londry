@extends('layouts.admin')

@section('title', 'Edit Pesanan')
@section('page_subtitle', 'Edit pesanan.')

@section('content')
    <x-admin.page-header
        :title="'Edit Pesanan: ' . $order->order_number"
        subtitle="Edit pesanan."
    >
        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-secondary rounded-4 px-4">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </x-admin.page-header>

    <div class="admin-card">
        <div class="admin-card-body">
            <div class="alert alert-primary border-0 rounded-4 mb-4" style="background:#eff6ff; color:#1d4ed8;">
                Berat final diisi admin setelah penimbangan manual. Status awal order customer tetap <strong>Menunggu Konfirmasi</strong>.
            </div>
            <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Customer</label>
                        <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', $order->customer_name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nomor WhatsApp</label>
                        <input type="text" name="customer_whatsapp" class="form-control" value="{{ old('customer_whatsapp', $order->customer_whatsapp) }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Alamat</label>
                        <textarea name="customer_address" class="form-control" required>{{ old('customer_address', $order->customer_address) }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jenis Layanan</label>
                        <select name="service_id" class="form-select" required>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id', $order->service_id) == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}/{{ $service->unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Berat Final</label>
                        <input type="number" step="0.1" min="0" name="weight" class="form-control" value="{{ old('weight', $order->weight) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tanggal</label>
                        <input type="date" name="pickup_date" class="form-control" value="{{ old('pickup_date', $order->pickup_date) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jam</label>
                        <input type="time" name="pickup_time" class="form-control" value="{{ old('pickup_time', $order->pickup_time) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status Laundry</label>
                        <select name="status" class="form-select" required>
                            @foreach(['Menunggu Konfirmasi', 'Dijemput', 'Dicuci', 'Disetrika', 'Selesai', 'Diantar'] as $status)
                                <option value="{{ $status }}" {{ old('status', $order->status) === $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Catatan</label>
                        <textarea name="notes" class="form-control">{{ old('notes', $order->notes) }}</textarea>
                    </div>
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-secondary rounded-4 px-4">Batal</a>
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-save me-2"></i>Update Pesanan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
