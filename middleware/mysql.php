<?php

// Konfigurasi koneksi database
// Variabel-variabel ini digunakan untuk menyimpan informasi koneksi ke database MySQL
$servername = "localhost"; // Alamat server database, biasanya 'localhost' untuk pengembangan lokal
$username = "root";        // Nama pengguna database
$password = "";            // Kata sandi database (kosong untuk pengembangan lokal)
$dbname = "kutabali";      // Nama database yang akan digunakan

// Mencoba membuat koneksi ke server MySQL
try {
    // Membuat objek koneksi mysqli baru tanpa memilih database tertentu
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (mysqli_sql_exception $e) {
    // Jika koneksi gagal, hentikan eksekusi dan tampilkan pesan error
    die("Koneksi gagal: " . $e->getMessage());
}

// Membuat tabel user jika belum ada
// Tabel ini akan menyimpan informasi pengguna seperti username dan password
$sql = "CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) !== TRUE) {
    // Jika gagal membuat tabel, hentikan eksekusi dan tampilkan pesan error
    die("Error membuat tabel: " . $conn->error);
}

// Memeriksa apakah tabel user kosong
$sql = "SELECT id FROM user";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    // Menambahkan user admin default jika tabel kosong
    // Ini memastikan bahwa selalu ada setidaknya satu akun admin
    $adminPassword = password_hash('admin', PASSWORD_DEFAULT); // Mengenkripsi password admin
    $sql = "INSERT INTO user (username, password) VALUES ('admin', '$adminPassword')";
    if ($conn->query($sql) !== TRUE) {
        // Jika gagal menambahkan user admin, hentikan eksekusi dan tampilkan pesan error
        die("Error menambahkan user admin: " . $conn->error);
    }
}

// Membuat tabel paket jika belum ada
// Tabel ini akan menyimpan informasi tentang paket wisata yang tersedia
$sqlPaket = "CREATE TABLE IF NOT EXISTS paket (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nama_paket VARCHAR(255) NOT NULL,
    harga INT(11) NOT NULL,
    deskripsi JSON NOT NULL,
    PRIMARY KEY (id)
)";
if ($conn->query($sqlPaket) !== TRUE) {
    // Jika gagal membuat tabel, hentikan eksekusi dan tampilkan pesan error
    die("Error membuat tabel: " . $conn->error);
}

// Membuat tabel layanan jika belum ada
// Tabel ini akan menyimpan informasi tentang layanan tambahan yang dapat dipilih oleh pelanggan
$sqlLayanan = "CREATE TABLE IF NOT EXISTS layanan (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nama_layanan VARCHAR(255) NOT NULL,
    harga INT(11) NOT NULL,
    PRIMARY KEY (id)
)";
if ($conn->query($sqlLayanan) !== TRUE) {
    // Jika gagal membuat tabel, hentikan eksekusi dan tampilkan pesan error
    die("Error membuat tabel: " . $conn->error);
}

// Membuat tabel booking jika belum ada
// Tabel ini akan menyimpan informasi tentang pemesanan yang dilakukan oleh pelanggan
$queryCreateTable = "CREATE TABLE IF NOT EXISTS booking (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255),
        email VARCHAR(255),
        phone VARCHAR(255),
        startDate DATE,
        endDate DATE,
        people INT,
        paket JSON,
        layanan JSON,
        totalHarga BIGINT,
        createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
if ($conn->query($queryCreateTable) !== TRUE) {
    // Jika gagal membuat tabel, hentikan eksekusi dan tampilkan pesan error
    die("Error membuat tabel: " . $conn->error);
}

// Membuat tabel contactme jika belum ada
// Tabel ini akan menyimpan pesan-pesan kontak dari pengunjung website
$sqlContactMe = "CREATE TABLE IF NOT EXISTS contactme (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL,
        subject VARCHAR(100) NOT NULL,
        message TEXT NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
if ($conn->query($sqlContactMe) !== TRUE) {
    // Jika gagal membuat tabel, hentikan eksekusi dan tampilkan pesan error
    die("Error membuat tabel: " . $conn->error);
}