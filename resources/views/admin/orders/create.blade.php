@extends('layouts.admin')

@section('title', 'Tambah Pesanan')
@section('page_subtitle', 'Tambah pesanan.')

@section('content')
    <x-admin.page-header
        title="Tambah Pesanan Manual"
        subtitle="Tambah pesanan."
    >
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary rounded-4 px-4">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </x-admin.page-header>

    <div class="admin-card">
        <div class="admin-card-body">
            <form method="POST" action="{{ route('admin.orders.store') }}">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Customer</label>
                        <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nomor WhatsApp</label>
                        <input type="text" name="customer_whatsapp" class="form-control" value="{{ old('customer_whatsapp') }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Alamat</label>
                        <textarea name="customer_address" class="form-control" required>{{ old('customer_address') }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jenis Layanan</label>
                        <select name="service_id" class="form-select" required>
                            <option value="">Pilih layanan</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}/{{ $service->unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Berat</label>
                        <input type="number" step="0.1" min="0" name="weight" class="form-control" value="{{ old('weight') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tanggal</label>
                        <input type="date" name="pickup_date" class="form-control" value="{{ old('pickup_date', date('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jam</label>
                        <input type="time" name="pickup_time" class="form-control" value="{{ old('pickup_time') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status Laundry</label>
                        <select name="status" class="form-select">
                            @foreach(['Menunggu Konfirmasi', 'Dijemput', 'Dicuci', 'Disetrika', 'Selesai', 'Diantar'] as $status)
                                <option value="{{ $status }}" {{ old('status', 'Menunggu Konfirmasi') === $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Catatan</label>
                        <textarea name="notes" class="form-control">{{ old('notes') }}</textarea>
                    </div>
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary rounded-4 px-4">Batal</a>
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-save me-2"></i>Simpan Pesanan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
