# Laundry Modern

Website laundry modern built with Laravel 12, Bootstrap 5, and MySQL.

## Fitur

### User
- Landing page
- Layanan laundry
- Form pemesanan
- Cek status pesanan dengan timeline

### Admin
- Dashboard dengan statistik
- Manajemen pesanan (CRUD)
- Manajemen layanan (CRUD)
- Manajemen transaksi
- Laporan sederhana

## Cara Setup

1. **Instal dependencies:**
   ```bash
   composer install
   ```

2. **Copy .env.example ke .env dan konfigurasi database:**
   ```bash
   cp .env.example .env
   ```

3. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

4. **Jalankan migration dan seeder:**
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan server:**
   ```bash
   php artisan serve
   ```

6. **Akses aplikasi:**
   - User: http://localhost:8000
   - Admin: http://localhost:8000/login
     - Email: admin@laundry.com
     - Password: password
