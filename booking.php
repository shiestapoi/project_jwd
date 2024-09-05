<?php
include 'middleware/mysql.php';

if (isset($_GET['success']) && $_GET['success'] == 'true') {
    echo '<script>alert("Booking berhasil ditambahkan");</script>';
}

if (isset($_GET['success']) && $_GET['success'] == 'false') {
    echo '<script>alert("Booking gagal ditambahkan");</script>';
}
try {
    $paket = $conn->query("SELECT * FROM paket");
    $paket = $paket->fetch_all(MYSQLI_ASSOC);
$hargapaket = [];
foreach ($paket as $item) {
    $hargapaket[$item['id']] = (int) $item['harga'];
}

$paketDetail = [];
foreach ($paket as $item) {
    $paketDetail[] = [
        'id' => $item['id'],
        'text' => $item['nama_paket'] . ' - Rp. ' . number_format($item['harga'], 0, ',', '.')
    ];
}

$layanan = $conn->query("SELECT * FROM layanan");
$layanan = $layanan->fetch_all(MYSQLI_ASSOC);
$hargalayanan = [];
foreach ($layanan as $item) {
    $hargalayanan[$item['id']] = (int) $item['harga'];
}

$layananDetail = [];
foreach ($layanan as $item) {
    $layananDetail[] = [
        'id' => $item['id'],
        'text' => $item['nama_layanan'] . ' - Rp. ' . number_format($item['harga'], 0, ',', '.')
    ];
}
} catch (Exception $e) {
    echo 'Tabel tidak ditemukan';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Now - Kuta Bali</title>
    <link rel="icon" type="image/ico" href="/assets/icon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <style>
    @font-face {
        font-family: 'Plus Jakarta Sans';
        src: url('assets/fonts/PlusJakartaSans-VariableFont_wght.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    body {
        background-color: #fff;
        font-family: 'Plus Jakarta Sans', sans-serif;
        margin: 0;
        padding: 0;
    }

    .navbar-custom {
        background-color: #1E1E1E;
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

    ::-webkit-scrollbar {
        width: 12px;
    }

    ::-webkit-scrollbar-track {
        background: #1E1E1E;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #555;
        border-radius: 10px;
        border: 3px solid #1E1E1E;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #28a745;
    }

    .booking-section {
        min-height: 100vh;
        display: flex;
        align-items: center;
        padding: 0 15px;
    }

    .booking-form {
        max-width: 600px;
        margin-right: 50px;
    }

    .fixed-right {
        padding-right: 0;
        display: flex;
        justify-content: flex-end;
    }

    .fixed-right img {
        width: 100%;
        height: 100vh;
        object-fit: cover;
    }

    .form-text {
        font-size: 0.875rem;
    }

    .list-unstyled {
        font-size: 14px;
        border-top: 2px solid #1E90FF;
        padding-top: 5px;
    }

    .list-unstyled li {
        margin-left: 5px;
        list-style-type: none;
        position: relative;
        padding-left: 20px;
    }

    .list-unstyled li::before {
        content: "\2713";
        position: absolute;
        left: 0;
        color: green;
    }

    @media (max-width: 991.98px) {
        .fixed-right {
            display: none;
        }
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom justify-content-center rounded-5 fixed-top mt-2 mx-auto"
        style="width: 7rem !important;">
        <a href="/" style="text-decoration: none; color: #fff;" class="d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                <path
                    d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
            </svg>
            <span class="fw-bold mx-2">Back</span>
        </a>
    </nav>
    <div class="container-fluid booking-section">
        <div class="row">
            <div class="col-lg-6 justify-content-center align-items-center "
                style="position: absolute; left: 0; top: 0; height: 100vh; overflow-y: auto; background-color: white; scrollbar-width: none; -ms-overflow-style: none; scrollbar-color: transparent transparent;">
                <div style="margin-left: 20px !important; margin-top: 100px !important;">
                    <h1 class="mb-4">Nikmati liburan tak terlupakan dengan paket wisata terbaik kami</h1>
                    <form class="booking-form" action="/api/booking" method="post">
                        <div class="mb-3 d-flex">
                            <div class="flex-fill me-2">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Budi Santoso"
                                    required>
                            </div>
                            <div class="flex-fill ms-2">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="budisantoso@gmail.com" required>
                            </div>
                        </div>
                        <div class="mb-3 d-flex">
                            <div class="flex-fill me-2">
                                <label for="startDate" class="form-label">Tanggal Mulai Liburan</label>
                                <input type="date" class="form-control" id="startDate" name="startDate" required
                                    min="<?php echo date('Y-m-d'); ?>"
                                    max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>"
                                    onchange="hitungTotalHargaRealtime()">
                            </div>
                            <div class="flex-fill ms-2">
                                <label for="endDate" class="form-label">Tanggal Berakhir Liburan</label>
                                <input type="date" class="form-control" id="endDate" name="endDate" required disabled
                                    onchange="hitungTotalHargaRealtime()">
                            </div>
                        </div>
                        <div class="mb-3 d-flex">
                            <div class="flex-fill me-2">
                                <label for="numberOfPeople" class="form-label">Jumlah Orang</label>
                                <input type="number" class="form-control" id="numberOfPeople" name="numberOfPeople"
                                    placeholder="1" required min="1" onchange="hitungTotalHargaRealtime()">
                            </div>
                            <div class="flex-fill me-2">
                                <label for="phoneNumber" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber"
                                    placeholder="+62 812 3456 7890" required>
                            </div>
                        </div>
                        <div class="mb-3 d-flex">
                            <div class="flex-fill me-2">
                                <label for="package" class="form-label">Pilih Paket : <strong
                                        class="pilihpaket"></strong></label>
                                <input type="hidden" name="pilihpaket" id="pilihpaket" required>
                                <div>
                                    <a href="#" class="btn btn-success d-flex align-items-center" data-bs-toggle="modal"
                                        data-bs-target="#PaketModal" style="width: 140px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-backpack-fill me-2" viewBox="0 0 16 16">
                                            <path
                                                d="M8 0a2 2 0 0 0-2 2v.341C3.67 3.165 2 5.388 2 8v5.5A2.5 2.5 0 0 0 4.5 16h7a2.5 2.5 0 0 0 2.5-2.5V8a6 6 0 0 0-4-5.659V2a2 2 0 0 0-2-2zm0 1a1 1 0 0 1 1 1v.083a6 6 0 0 0-2 0V2a1 1 0 0 1 1-1zm0 3a4 4 0 0 1 3.96 3.43.5.5 0 1 1-.99.14 3 3 0 0 0-5.94 0 .5.5 0 1 1-.99-.14A4 4 0 0 1 8 4zm-3.5 5h7a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5zm1.5 1v3h4v-.5a.5.5 0 0 1 1 0v.5h1v-3H6z" />
                                        </svg> <span class="apilihpaket">Pilih Paket</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 d-flex">
                            <div class="flex-fill me-2">
                                <label for="package" class="form-label">Layanan Tambahan : <Strong><span
                                            class="pilihlayanan">0</span> Layanan di Pilih</Strong></label>
                                <div id="pilihlayananinput">
                                </div>
                                <div>
                                    <a href="#" class="btn btn-success apilihpaket d-flex align-items-center"
                                        data-bs-toggle="modal" data-bs-target="#LayananModal" style="width: 230px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-card-checklist me-2" viewBox="0 0 16 16">
                                            <path
                                                d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z" />
                                            <path
                                                d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0M7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0" />
                                        </svg> Pilih Layanan Tambahan
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow-sm mb-3">
                            <div class="card-header text-white" style="background-color: #1E1E1E;">
                                Detail Booking
                            </div>
                            <style>
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
                            <ul class="list-group list-group-flush" id="detailBooking">
                                <li class="list-group-item no-check">
                                    Informasi lebih lanjut akan ditampilkan di sini.
                                </li>
                            </ul>
                        </div>
                        <label for="totalHarga" class="form-label">Total Harga:</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp.</span>
                            <input type="text" class="form-control" id="totalHarga" name="totalHarga" value="0"
                                disabled>
                        </div>
                        <div class="form-check mt-4 mb-1">
                            <input class="form-check-input" type="checkbox" value="" id="noRefundCheckbox" required>
                            <label class="form-check-label" for="noRefundCheckbox">
                                Saya mengerti dan setuju bahwa pemesanan ini tidak dapat di-refund.
                            </label>
                        </div>
                        <button type="submit"
                            class="btn btn-dark w-100 d-flex align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-journal-plus me-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5">
                                </path>
                                <path
                                    d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2">
                                </path>
                                <path
                                    d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z">
                                </path>
                            </svg>
                            <span style="font-weight: 600;">Booking Sekarang</span>
                        </button>
                        <div class="form-text mt-2 mb-2">*Harap isi formulir dengan informasi yang benar, tim kami akan
                            segera menghubungi Anda
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 fixed-right"
                style="position: absolute; right: 0; top: 0; margin: 0; padding-right: 0;">
                <img src="/assets/images/booking.png" alt="Booking Destination" class="img-fluid">
            </div>
        </div>
    </div>
    <div class="modal fade" id="PaketModal" tabindex="-1" aria-labelledby="PaketModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="PaketLabel">Detail Paket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (empty($paket)) : ?>
                    <div class="alert alert-info" role="alert">
                        Tidak ada paket yang tersedia saat ini.
                    </div>
                    <?php else : ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <?php foreach ($paket as $paketd) : ?>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?php echo $paketd['nama_paket']; ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Rp
                                        <?php echo number_format($paketd['harga'], 0, ',', '.'); ?>/hari</h6>
                                    <ul class="list-unstyled flex-grow-1">
                                        <?php foreach (json_decode($paketd['deskripsi'], true) as $deskripsi) : ?>
                                        <li><?php echo $deskripsi; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <a class="btn btn-primary pilihpaket mt-auto align-self-start"
                                        onclick="pilihpaket('<?php echo $paketd['nama_paket'] . ' - Rp ' . number_format($paketd['harga'], 0, ',', '.') . '/hari'; ?>', <?php echo $paketd['id']; ?>)"
                                        data-bs-dismiss="modal">Pilih Paket</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="LayananModal" tabindex="-1" aria-labelledby="LayananModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="LayananLabel">Pilihan Layanan Tambahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <?php if (empty($layanan)) : ?>
                    <div class="alert alert-info" role="alert">
                        Tidak ada layanan tambahan yang tersedia saat ini.
                    </div>
                    <?php else : ?>
                    <div class="row" id="layananPilihan">
                        <?php foreach (array_chunk($layanan, ceil(count($layanan) / 2)) as $layananChunk) : ?>
                        <div class="col-md-6">
                            <?php foreach ($layananChunk as $layananItem) : ?>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input"
                                    id="layanan<?php echo $layananItem['id']; ?>"
                                    name="layanan<?php echo $layananItem['id']; ?>"
                                    value="<?php echo $layananItem['id']; ?>">
                                <label class="form-check-label"
                                    for="layanan<?php echo $layananItem['id']; ?>"><?php echo $layananItem['nama_layanan']; ?>
                                    - Rp <?php echo number_format($layananItem['harga'], 0, ',', '.'); ?>/hari</label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="pilihLayanan()" data-bs-dismiss="modal">Pilih
                        Layanan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.js"></script>
    <script>
    const layananArray = <?php echo json_encode($layananDetail); ?>;
    const paketArray = <?php echo json_encode($paketDetail); ?>;
    var hargaData = {
        paket: <?php echo json_encode($hargapaket); ?>,
        layanan: <?php echo json_encode($hargalayanan); ?>
    };
    </script>
    <script src="assets/js/booking.js"></script>
</body>

</html>