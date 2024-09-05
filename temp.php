<?php
include 'middleware/mysql.php';

// $sql = "CREATE TABLE IF NOT EXISTS paket (
//     id INT(11) NOT NULL AUTO_INCREMENT,
//     nama_paket VARCHAR(255) NOT NULL,
//     harga INT(11) NOT NULL,
//     deskripsi JSON NOT NULL,
//     PRIMARY KEY (id)
// )";

// if ($conn->query($sql) === TRUE) {
//     $paketData = [
//         ['Paket A', 350000, json_encode(["Hotel Bintang 1", "Restoran standar dengan 2x makan sehari", "Pemandu Wisata", "Akses Destinasi Wisata"])],
//         ['Paket B', 500000, json_encode(["Hotel Bintang 2", "Restoran premium dengan 3x makan sehari", "Pemandu Wisata", "Akses Destinasi Wisata"])],
//         ['Paket C', 1000000, json_encode(["Hotel Bintang 3", "Restoran eksklusif dengan 3x makan sehari", "Pemandu Wisata", "Akses Destinasi Wisata"])]
//     ];

//     foreach ($paketData as $paket) {
//         $sql = "INSERT INTO paket (nama_paket, harga, deskripsi) VALUES (?, ?, ?)";
//         $stmt = $conn->prepare($sql);
//         $stmt->bind_param("sis", $paket[0], $paket[1], $paket[2]);
//         $stmt->execute();
//     }
// } else {
//     die("Error membuat tabel: " . $conn->error);
// }


// $sql = "CREATE TABLE IF NOT EXISTS layanan (
//     id INT(11) NOT NULL AUTO_INCREMENT,
//     nama_layanan VARCHAR(255) NOT NULL,
//     harga INT(11) NOT NULL,
//     PRIMARY KEY (id)
// )";

// if ($conn->query($sql) === TRUE) {
//     $layananData = [
//         ['Penjaga', 100000],
//         ['Layanan Bar', 200000],
//         ['Layanan Spa', 300000],
//         ['Layanan Laundry', 150000],
//         ['Layanan Gym', 250000],
//         ['Layanan Transportasi', 400000],
//         ['Sarapan di Kamar', 100000],
//         ['Layanan Fotografi', 50000],
//         ['Pengalaman Budaya', 600000],
//         ['Tur Kuliner', 300000],
//         ['Makan Malam di Pantai', 450000]
//     ];

//     foreach ($layananData as $layanan) {
//         $sql = "INSERT INTO layanan (nama_layanan, harga) VALUES (?, ?)";
//         $stmt = $conn->prepare($sql);
//         $stmt->bind_param("si", $layanan[0], $layanan[1]);
//         $stmt->execute();
//     }
// } else {
//     die("Error membuat tabel: " . $conn->error);
// }