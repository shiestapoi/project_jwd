<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History - Kuta Bali</title>
    <link rel="icon" type="image/ico" href="/assets/icon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
    @font-face {
        font-family: 'Plus Jakarta Sans';
        src: url('assets/fonts/PlusJakartaSans-VariableFont_wght.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    body {
        background-color: #1E1E1E;
        color: #fff;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .btn-dark {
        background-color: #28a745;
        border: none;
    }

    .modal-content {
        background-color: #333;
        color: #fff;
    }

    .navbar-custom {
        background-color: #fff;
        border-radius: 20px;
        padding: 10px;
    }

    .nav-link {
        color: #fff;
        font-weight: bold;
        padding: 0 20px;
    }

    .nav-link:hover {
        color: #28a745;
    }

    .nav-active {
        color: #1E90FF;
    }

    #detailBooking li {
        font-size: 14px;
        list-style-type: none;
    }

    #detailBooking li::before {
        content: '✓';
        color: green;
        margin-right: 5px;
    }

    #detailBooking .no-check::before {
        content: none;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom justify-content-center rounded-5 fixed-top mt-2 mx-auto"
        style="width: 7rem !important;">
        <a href="/" style="text-decoration: none; color: #000;" class="d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                <path
                    d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
            </svg>
            <span class="fw-bold mx-2">Back</span>
        </a>
    </nav>
    <div class="container mt-5">
        <h2 class="mb-4">Booking History</h2>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th scope="col">ID Pesanan</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Paket</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'middleware/mysql.php';
                if (isset($_COOKIE['bookingHistory'])) {
                    $bookingIds = json_decode($_COOKIE['bookingHistory'], true);
                    if (!empty($bookingIds)) {
                        $placeholders = implode(',', array_fill(0, count($bookingIds), '?'));
                        $querySelectHistory = "SELECT id, name, paket, email, phone, startDate, endDate, people, layanan, totalHarga, createdAt FROM booking WHERE id IN ($placeholders)";
                        $stmt = $conn->prepare($querySelectHistory);
                        $stmt->bind_param(str_repeat('i', count($bookingIds)), ...$bookingIds);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            $paket = json_decode($row['paket'], true);
                            $namaPaket = $paket['nama_paket'];
                            $hargaPaket = number_format($paket['harga'], 0, ',', '.');
                            echo "<tr>
                                    <th scope='row'>{$row['id']}</th>
                                    <td>{$row['name']}</td>
                                    <td>{$namaPaket} - Rp. {$hargaPaket}</td>
                                    <td>
                                        <button type='button' class='btn btn-dark' data-bs-toggle='modal' data-bs-target='#modalDetail{$row['id']}'>
                                            Lihat Detail
                                        </button>
                                    </td>
                                </tr>";
                            echo "<div class='modal fade' id='modalDetail{$row['id']}' tabindex='-1' aria-labelledby='modalDetailLabel{$row['id']}' aria-hidden='true'>
                                    <div class='modal-dialog'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='modalDetailLabel{$row['id']}'>Detail Pesanan #{$row['id']}</h5>
                                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                            </div>
                                            <div class='modal-body'>
                                                <p><strong>Nama:</strong> {$row['name']}</p>
                                                <p><strong>Email:</strong> {$row['email']}</p>
                <p><strong>Telepon:</strong> {$row['phone']}</p>
                <p><strong>Tanggal Mulai:</strong> " . date('d F Y', strtotime($row['startDate'])) . "</p>
                <p><strong>Tanggal Selesai:</strong> " . date('d F Y', strtotime($row['endDate'])) . "</p>
                <p><strong>Jumlah Orang:</strong> {$row['people']}</p>
                <p><strong>Tanggal Pesan:</strong> " . date('d F Y - H:i', strtotime($row['createdAt'])) . "</p>
                <p><strong>Total Harga:</strong> Rp. " . number_format($row['totalHarga'], 0, ',', '.') . "</p>
                <div class='card shadow-sm mb-3 bg-dark'>
                    <div class='card-header text-white'>Detail Paket</div>
                    <ul class='list-group list-group-flush' id='detailPaket'>
                        <li class='list-group-item no-check'><strong>Paket:</strong> {$namaPaket} - Rp. {$hargaPaket}
                        </li>
                    </ul>
                </div>
                <div class='card shadow-sm mb-3 bg-dark'>
                    <div class='card-header text-white'>Detail Layanan</div>
                    <ul class='list-group list-group-flush' id='detailLayanan'>";
                        $layanan = json_decode($row['layanan'], true);
                        $layananFormatted = [];
                        foreach ($layanan as $item) {
                        $layananFormatted[] = "<li class='list-group-item'>{$item['nama_layanan']} - Rp. " .
                            number_format($item['harga'], 0, ',', '.') . "</li>";
                        }
                        echo implode('', $layananFormatted);
                        echo "</ul>
                </div>
    </div>
    <div class='modal-footer'>
        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
    </div>
    </div>
    </div>
    </div>";
    }
    } else {
    echo "<tr>
        <td colspan='4'>No booking history found.</td>
    </tr>";
    }
    } else {
    echo "<tr>
        <td colspan='4'>No booking history found.</td>
    </tr>";
    }
    ?>
            </tbody>
        </table>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>