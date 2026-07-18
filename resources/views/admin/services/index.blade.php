@extends('layouts.admin')

@section('title', 'Layanan & Harga')
@section('page_subtitle', 'Kelola layanan.')

@section('content')
    <x-admin.page-header
        title="Layanan"
        subtitle="Kelola layanan."
    >
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary-custom">
            <i class="bi bi-plus-lg me-2"></i>Tambah
        </a>
    </x-admin.page-header>

    <div class="row g-4">
        @forelse($services as $service)
            <div class="col-md-6 col-xl-4">
                <div class="admin-card h-100">
                    <div class="admin-card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="admin-stat-card__icon admin-stat-card--primary" style="width:48px;height:48px;border-radius:16px;font-size:1.1rem;">
                                <i class="bi bi-basket2"></i>
                            </div>
                            <span class="admin-badge {{ $service->is_active ? 'admin-badge--success' : 'admin-badge--slate' }}">
                                {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <h5 class="mb-1">{{ $service->name }}</h5>
                        <div class="text-primary fw-semibold mb-2">Rp {{ number_format($service->price, 0, ',', '.') }} / {{ $service->unit }}</div>
                        <p class="text-secondary mb-4">{{ \Illuminate\Support\Str::limit($service->description ?: 'Tanpa deskripsi.', 72) }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <small class="text-secondary">{{ $service->estimated_days }} hari</small>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-secondary btn-icon-clean" data-bs-toggle="tooltip" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger btn-icon-clean" onclick="deleteService({{ $service->id }})" data-bs-toggle="tooltip" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="admin-card">
                    <div class="admin-empty-state">
                        <i class="bi bi-basket2 fs-1 d-block mb-3 text-secondary"></i>
                        Belum ada layanan yang tersimpan.
                    </div>
                </div>
            </div>
        @endforelse
    </div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((element) => {
        new bootstrap.Tooltip(element);
    });

    function deleteService(id) {
        Swal.fire({
            title: 'Yakin?',
            text: 'Layanan ini akan dihapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/services/${id}`;
                form.innerHTML = '@csrf @method('DELETE')';
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@endsection
