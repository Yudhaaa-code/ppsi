# Sistem Login dengan 3 Role (Customer, Developer, Admin)

## Fitur yang Telah Dibuat

### 1. Database & Model
- ✅ Migration users table dengan kolom role (enum: customer, developer, admin)
- ✅ User model dengan helper methods untuk role checking:
  - `isAdmin()`, `isDeveloper()`, `isCustomer()`
  - `hasRole($role)`

### 2. Authentication
- ✅ AuthController dengan fungsi:
  - Login (GET & POST)
  - Register (GET & POST)
  - Logout (POST)
  - Auto redirect berdasarkan role setelah login/register

### 3. Middleware
- ✅ RoleMiddleware untuk proteksi route berdasarkan role

### 4. Views
- ✅ Layout utama (layouts/app.blade.php)
- ✅ Layout dashboard (layouts/dashboard.blade.php)
- ✅ Halaman login (auth/login.blade.php)
- ✅ Halaman register (auth/register.blade.php)
- ✅ Dashboard Customer (dashboard/customer.blade.php)
- ✅ Dashboard Developer (dashboard/developer.blade.php)
- ✅ Dashboard Admin (dashboard/admin.blade.php)

### 5. Routes
- ✅ `/login` - Halaman login
- ✅ `/register` - Halaman registrasi
- ✅ `/logout` - Logout
- ✅ `/dashboard` - Redirect ke dashboard sesuai role
- ✅ `/customer/dashboard` - Dashboard customer (hanya bisa diakses customer)
- ✅ `/developer/dashboard` - Dashboard developer (hanya bisa diakses developer)
- ✅ `/admin/dashboard` - Dashboard admin (hanya bisa diakses admin)

## Langkah-langkah Setup

### 1. Install Dependencies
```bash
npm install -D tailwindcss postcss autoprefixer
```

### 2. Run Migration
```bash
php artisan migrate
```

### 3. Build Assets (untuk Tailwind CSS)
```bash
npm run dev
# atau untuk production:
npm run build
```

### 4. Jalankan Server
```bash
php artisan serve
```

## Cara Menggunakan

1. **Registrasi**: Kunjungi `/register` dan pilih role (customer, developer, atau admin)
2. **Login**: Kunjungi `/login` dan masukkan email/password
3. Setelah login, akan otomatis diarahkan ke dashboard sesuai role:
   - Customer → `/customer/dashboard`
   - Developer → `/developer/dashboard`
   - Admin → `/admin/dashboard`

## Catatan

- Setiap role memiliki dashboard terpisah dengan akses yang dibatasi oleh middleware
- Password akan di-hash otomatis saat registrasi
- Session akan tersimpan dengan "Remember Me" option
- Validasi form sudah diimplementasikan

