# Panduan Otomatisasi Update Status Order Midtrans

## Masalah
Saat menggunakan Midtrans Sandbox untuk pembayaran, status order tetap "pending" karena webhook notification tidak dapat menjangkau server localhost.

## Solusi
Terdapat 2 solusi yang tersedia:

### Solusi 1: Ngrok Tunnel (Rekomendasi untuk Testing)
Menggunakan ngrok untuk mengekspose localhost agar dapat diakses oleh Midtrans webhook.

#### Langkah-langkah:
1. **Install Ngrok**
   ```bash
   # Download dari https://ngrok.com/download
   # Extract dan tambahkan ke PATH system
   ```

2. **Setup Ngrok**
   ```bash
   # Daftar akun di https://dashboard.ngrok.com
   # Dapatkan auth token
   ngrok authtoken YOUR_AUTH_TOKEN
   ```

3. **Jalankan Ngrok**
   ```bash
   # Jalankan script setup
   php setup_ngrok.php
   
   # Atau manual
   ngrok http 8000
   ```

4. **Update Configuration**
   - Copy HTTPS URL dari output ngrok (misal: https://abc123.ngrok.io)
   - Update Midtrans Dashboard:
     - Login ke https://dashboard.midtrans.com
     - Settings > Configuration
     - Payment Notification URL: `https://abc123.ngrok.io/midtrans/notification`

### Solusi 2: Automatic Polling (Alternative)
Menggunakan scheduled command untuk mengecek status order secara berkala.

#### Fitur:
- Mengecek order dengan status "pending" setiap 5 menit
- Mengupdate status berdasarkan data dari Midtrans API
- Otomatis update dashboard admin

#### Cara Penggunaan:

1. **Manual Check (Sekali Jalankan)**
   ```bash
   # Check semua order pending
   php artisan orders:check-pending
   
   # Check order tertentu
   php artisan orders:check-pending --order_number=ORD-1234567890
   ```

2. **Automatic Polling (Berjalan Otomatis)**
   ```bash
   # Jalankan scheduler (development)
   php artisan schedule:work
   
   # Atau setup cron (production)
   * * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
   ```

## Testing Status Update

### 1. Buat Order Baru
- Lakukan pembelian Robux seperti biasa
- Simpan order number yang dihasilkan

### 2. Simulasi Pembayaran Sandbox
- Gunakan kartu kredit testing: `4811 1111 1111 1114`
- CVV: `123`
- Expiry: `12/25`

### 3. Monitor Status
```bash
# Check log untuk melihat update
php artisan orders:check-pending --order_number=YOUR_ORDER_NUMBER
tail -f storage/logs/laravel.log
```

### 4. Verifikasi di Dashboard
- Login ke admin dashboard
- Cek halaman order untuk melihat status yang terupdate

## Command yang Tersedia

| Command | Fungsi |
|---------|--------|
| `php artisan orders:check-pending` | Check semua order pending |
| `php artisan orders:check-pending --order_number=ORD-123` | Check order tertentu |
| `php artisan schedule:work` | Jalankan scheduler untuk development |
| `php setup_ngrok.php` | Setup ngrok tunnel otomatis |

## Troubleshooting

### Order tetap pending?
1. Check log: `tail -f storage/logs/laravel.log`
2. Pastikan Midtrans API key benar
3. Cek koneksi internet
4. Gunakan manual check: `php artisan orders:check-pending`

### Ngrok tidak berfungsi?
1. Pastikan ngrok terinstall: `ngrok version`
2. Check auth token: `ngrok authtoken YOUR_TOKEN`
3. Pastikan port 8000 tidak digunakan

### Scheduler tidak jalan?
1. Jalankan manual: `php artisan schedule:work`
2. Check cron setup untuk production
3. Pastikan queue worker jika menggunakan queue

## Status Mapping

| Midtrans Status | Order Status | Keterangan |
|----------------|--------------|------------|
| settlement | completed | Pembayaran berhasil |
| capture | completed | Pembayaran berhasil |
| pending | pending | Menunggu pembayaran |
| deny | failed | Pembayaran ditolak |
| cancel | failed | Pembayaran dibatalkan |
| expire | failed | Pembayaran kadaluarsa |

## Keamanan
- Webhook endpoint `/midtrans/notification` otomatis terverifikasi oleh Midtrans
- Gunakan HTTPS untuk production
- Validasi signature untuk keamanan tambahan

## Catatan Production
Untuk environment production:
1. Gunakan domain resmi dengan SSL
2. Setup cron job untuk scheduler
3. Monitor log secara berkala
4. Gunakan Midtrans production mode
5. Setup proper error handling dan alerting