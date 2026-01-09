# Panduan Konfigurasi Midtrans Payment Gateway

Untuk mengaktifkan fitur pembayaran, Anda perlu mendapatkan API Key dari Midtrans.

## 1. Dapatkan API Key
1. Login ke [Midtrans Dashboard](https://dashboard.midtrans.com/).
2. Pastikan Anda berada di mode **Sandbox** (untuk testing) atau **Production** (untuk live).
3. Buka menu **Settings** > **Access Keys**.
4. Salin **Server Key** dan **Client Key**.

## 2. Masukkan ke File .env
Buka file `.env` di root folder project, lalu cari bagian ini dan ganti dengan key Anda:

```env
MIDTRANS_SERVER_KEY=masukkan-server-key-anda-disini
MIDTRANS_CLIENT_KEY=masukkan-client-key-anda-disini
MIDTRANS_IS_PRODUCTION=false  # Set 'true' jika sudah Production
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

## 3. Clear Cache (Opsional)
Jika perubahan tidak terdeteksi, jalankan perintah ini di terminal:
```bash
php artisan config:cache
```

## Catatan
- Jangan pernah membagikan Server Key Anda kepada publik.
- Pastikan `MIDTRANS_IS_PRODUCTION` sesuai dengan environment key yang Anda gunakan (Sandbox/Production).
