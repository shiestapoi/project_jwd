# Parawisata Kuta di Bali Pages

Parawisata Kuta di Bali adalah sebuah situs web yang memungkinkan Anda untuk memesan sebuah paket wisata di Kuta Bali dengan harga terjangkau dan berkualitas.

## Features

- Booking Paket Wisata
- Booking History
- Admin Page
- Manajemen Paket Wisata
- Manajemen Layanan Tambahan
- Auto Pembuatan Table Database
- Auto Pembuatan akun admin

## Requirements

- PHP 8.0 ke atas
- MySQL 5.7 ke atas
- Apache 2.4 ke atas
- Composer
- Git

## Installation

1. Clone the repository

```bash
git clone https://github.com/shiestapoi/project_jwd.git
```

2. Pindah kan ke direktori xampp atau /var/www/html/

3. Konfigurasi Database
   Edit file [`middleware/mysql.php`](middleware/mysql.php) untuk menyesuaikan informasi koneksi database:

```php
$host = 'localhost';     // sesuaikan dengan alamat server database
$db = 'nama_database';   // nama database yang sudah dibuat
$user = 'root';          // username MySQL
$pass = '';              // password MySQL
```

## Route Web

### Public access

- `/` : Home Page
- `/booking` : Booking Page
- `/riwayat` : Booking History Page by cookie

### Admin access

- `/admin/login` : Admin Login Page
- `/admin/dashboard` : Admin Dashboard Page
- `/admin/booking` : All Booking History Page
- `/admin/paket` : Paket Wisata Management Page
- `/admin/layanan` : Layanan Tambahan Management Page
- `/admin/profile` : User Admin Management Page
- `/admin/logout` : Admin Logout Page
