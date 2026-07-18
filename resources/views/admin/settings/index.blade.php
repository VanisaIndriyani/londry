@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('page_subtitle', 'Pengaturan laundry.')

@section('content')
    <x-admin.page-header title="Pengaturan" subtitle="Pengaturan laundry." />

    <div class="admin-card">
        <div class="admin-card-body">
            <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-12">
                        <div class="d-flex align-items-center gap-3 p-3 rounded-4" style="background:#f8fafc;">
                            <div id="logoPreviewBox" style="width:72px;height:72px;border-radius:20px;overflow:hidden;background:#eef4ff;display:flex;align-items:center;justify-content:center;border:1px solid rgba(37,99,235,.12);">
                                @if(!empty($settings['logo']))
                                    <img id="logoPreviewImage" src="{{ \App\Support\AdminSettings::logoUrl($settings['logo']) }}" alt="Preview Logo" style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    <i id="logoPreviewIcon" class="bi bi-droplet-half text-primary" style="font-size:1.5rem;"></i>
                                    <img id="logoPreviewImage" src="" alt="Preview Logo" style="display:none;width:100%;height:100%;object-fit:cover;">
                                @endif
                            </div>
                            <div>
                                <div class="fw-semibold">Preview Logo</div>
                                <small class="text-secondary">Logo ini tampil di sidebar admin dan navbar halaman user.</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Laundry</label>
                        <input type="text" name="laundry_name" class="form-control" value="{{ old('laundry_name', $settings['laundry_name']) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Logo</label>
                        <input type="file" name="logo" id="logoInput" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">WhatsApp Admin</label>
                        <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $settings['whatsapp']) }}" required>
                        <small class="text-secondary">Dipakai untuk tombol order WhatsApp customer.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jam Operasional</label>
                        <input type="text" name="operational_hours" class="form-control" value="{{ old('operational_hours', $settings['operational_hours']) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $settings['email']) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Instagram</label>
                        <input type="text" name="instagram" class="form-control" value="{{ old('instagram', $settings['instagram']) }}">
                        <small class="text-secondary">Muncul pada bagian footer halaman user.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Facebook</label>
                        <input type="text" name="facebook" class="form-control" value="{{ old('facebook', $settings['facebook']) }}">
                        <small class="text-secondary">Muncul pada bagian footer halaman user.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Alamat</label>
                        <textarea name="address" class="form-control" required>{{ old('address', $settings['address']) }}</textarea>
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
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('logoInput');
        const image = document.getElementById('logoPreviewImage');
        const icon = document.getElementById('logoPreviewIcon');

        if (!input || !image) {
            return;
        }

        input.addEventListener('change', function (event) {
            const [file] = event.target.files || [];

            if (!file) {
                return;
            }

            const reader = new FileReader();
            reader.onload = function (loadEvent) {
                image.src = loadEvent.target.result;
                image.style.display = 'block';

                if (icon) {
                    icon.style.display = 'none';
                }
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endsection
