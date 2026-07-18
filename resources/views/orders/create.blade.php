@extends('layouts.user')

@section('title', 'Pesan Laundry')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card card-custom">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Form Pemesanan Laundry</h2>
                        <form id="orderForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="customer_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor WhatsApp</label>
                                <input type="text" name="customer_whatsapp" class="form-control" required placeholder="081234567890">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="customer_address" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Layanan</label>
                                <select name="service_id" class="form-select" required>
                                    <option value="">Pilih Layanan</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" data-price="{{ $service->price }}" data-unit="{{ $service->unit }}">
                                            {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }} / {{ $service->unit }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Info</label>
                                <div class="form-control d-flex align-items-center text-secondary">
                                    Berat dan pembayaran dikonfirmasi manual via WhatsApp admin.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catatan (Opsional)</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Penjemputan</label>
                                    <input type="date" name="pickup_date" class="form-control" required min="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jam Penjemputan</label>
                                    <input type="time" name="pickup_time" class="form-control" required>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary-custom btn-lg">
                                    <i class="bi bi-send me-2"></i>Kirim Pesanan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('orderForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            try {
                const response = await fetch('{{ route('order.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pesanan Berhasil!',
                        html: `Nomor Pesanan Anda: <strong>${data.order_number}</strong><br>Silakan simpan nomor ini untuk mengecek status laundry.`,
                        confirmButtonText: 'Buka WhatsApp'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.open(data.whatsapp_url, '_blank');
                            window.location.href = '{{ route('home') }}';
                        }
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan, silakan coba lagi.'
                });
            }
        });
    });
</script>
@endsection
