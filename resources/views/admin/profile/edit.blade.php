@extends('layouts.admin')

@section('title', 'Profil')
@section('page_subtitle', 'Profil admin.')

@section('content')
    <x-admin.page-header title="Profil" subtitle="Profil admin." />

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="admin-card h-100">
                <div class="admin-card-body text-center">
                    <div class="admin-user-avatar mx-auto mb-3" style="width:72px;height:72px;border-radius:24px;font-size:1.5rem;">
                        {{ collect(explode(' ', $admin->name))->filter()->take(2)->map(fn ($item) => strtoupper(substr($item, 0, 1)))->implode('') }}
                    </div>
                    <h5 class="mb-1">{{ $admin->name }}</h5>
                    <p class="text-secondary mb-0">{{ $admin->email }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="admin-card-body">
                    <form method="POST" action="{{ route('admin.profile.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Password Baru</label>
                                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password">
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="bi bi-save me-2"></i>Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
