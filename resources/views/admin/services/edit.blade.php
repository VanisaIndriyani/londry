@extends('layouts.admin')

@section('title', 'Edit Layanan')
@section('page_subtitle', 'Edit layanan.')

@section('content')
    <x-admin.page-header
        :title="'Edit Layanan: ' . $service->name"
        subtitle="Edit layanan."
    >
        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary rounded-4 px-4">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </x-admin.page-header>

    <div class="admin-card">
        <div class="admin-card-body">
            <form method="POST" action="{{ route('admin.services.update', $service) }}">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Layanan</label>
                        <input type="text" name="name" class="form-control" required value="{{ old('name', $service->name) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Harga</label>
                        <input type="number" name="price" class="form-control" required min="0" value="{{ old('price', $service->price) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Satuan</label>
                        <select name="unit" class="form-select" required>
                            <option value="kg" {{ old('unit', $service->unit) == 'kg' ? 'selected' : '' }}>kg</option>
                            <option value="item" {{ old('unit', $service->unit) == 'item' ? 'selected' : '' }}>item</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Estimasi Hari</label>
                        <input type="number" name="estimated_days" class="form-control" required min="1" value="{{ old('estimated_days', $service->estimated_days) }}">
                    </div>
                    <div class="col-md-9">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" class="form-control">{{ old('description', $service->description) }}</textarea>
                    </div>
                    <div class="col-12">
                        <div class="form-check form-switch mt-2">
                            <input type="checkbox" name="is_active" class="form-check-input" id="isActive" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="isActive">Status aktif</label>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary rounded-4 px-4">Batal</a>
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-save me-2"></i>Update Layanan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
