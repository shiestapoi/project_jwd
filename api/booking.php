<?php
include '../middleware/mysql.php';

try {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phoneNumber'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $people = $_POST['numberOfPeople'];

    $paketId = $_POST['pilihpaket'];
    $layananIds = $_POST['pilihlayanan'];

    $queryPaket = "SELECT * FROM paket WHERE id = ?";
    $stmt = $conn->prepare($queryPaket);
    $stmt->bind_param("i", $paketId);
    $stmt->execute();
    $resultPaket = $stmt->get_result();
    $paket = json_encode($resultPaket->fetch_assoc());
    $layananInfo = [];
    if (!empty($layananIds)) {
        $placeholders = implode(',', array_fill(0, count($layananIds), '?'));
        $types = str_repeat('i', count($layananIds));
        $queryLayanan = "SELECT * FROM layanan WHERE id IN ($placeholders)";
        $stmt = $conn->prepare($queryLayanan);
        $stmt->bind_param($types, ...$layananIds);
        $stmt->execute();
        $resultLayanan = $stmt->get_result();
        while ($row = $resultLayanan->fetch_assoc()) {
            $layananInfo[] = $row;
        }
        $layananInfo = json_encode($layananInfo);
    }

    $totalHarga = 0;
    $paketData = json_decode($paket, true);
    $layananData = json_decode($layananInfo, true);

    if ($paketData) {
        $totalHarga += $paketData['harga'] * $people;
    }

    foreach ($layananData as $layanan) {
        $totalHarga += $layanan['harga'];
    }

    $startDate = new DateTime($startDate);
    $endDate = new DateTime($endDate);
    $interval = $startDate->diff($endDate);
    $totalHari = $interval->days + 1; 

    $totalHarga *= $totalHari;

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

    $conn->query($queryCreateTable);

    $queryInsertBooking = "INSERT INTO booking (name, email, phone, startDate, endDate, people, paket, layanan, totalHarga) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($queryInsertBooking);
    $stmt->bind_param("sssssissi", $name, $email, $phone, $startDate->format('Y-m-d'), $endDate->format('Y-m-d'), $people, $paket, $layananInfo, $totalHarga);
    $stmt->execute();

    $bookingId = $conn->insert_id;
    if (isset($_COOKIE['bookingHistory'])) {
        $existingBookings = json_decode($_COOKIE['bookingHistory'], true);
        array_push($existingBookings, $bookingId);
        setcookie('bookingHistory', json_encode($existingBookings), 0, "/");
    } else {
        setcookie('bookingHistory', json_encode([$bookingId]), 0, "/");
    }
    header('Location: /booking?success=true');
} catch (Exception $e) {
    header('Location: /booking?success=false');
}