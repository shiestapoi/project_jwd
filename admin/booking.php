<?php
include '../middleware/mysql.php';
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: /admin/login');
    exit;
}

if (isset($_POST['id'])) {
    try {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM booking WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: /admin/booking?message='Berhasil menghapus booking'");
    exit();
    } catch (mysqli_sql_exception $e) {
        header("Location: /admin/booking?error='Gagal menghapus booking'");
        exit();
    }
}
$stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$title = 'Booking';
include 'components/header.php';
?>
<style>
#deskripsiPaket {
    list-style-type: none;
    padding-left: 0;
}

#deskripsiPaket li::before {
    content: "✓";
    color: #28a745;
    font-weight: bold;
    display: inline-block;
    width: 1em;
}
</style>
<div class="container mb-5" style="margin-top: 100px;">
    <div class="card" style="background-color: #333;">
        <div class="card-header" style="background-color: #191E2B;">
            <h1 style="color: #fff;">Booking Listing</h1>
        </div>
        <div class="card-body p-0">
            <?php
            $query = "SELECT * FROM booking ORDER BY createdAt DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                echo '<table class="table table-dark table-hover">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Nama</th>';
                echo '<th>Email</th>';
                echo '<th>Telepon</th>';
                echo '<th>Tanggal Mulai</th>';
                echo '<th>Tanggal Selesai</th>';
                echo '<th>Total Biaya</th>';
                echo '<th>Aksi</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ($row = $result->fetch_assoc()) {
                    $modalId = 'modalBooking' . $row['id'];
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['startDate']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['endDate']) . '</td>';
                    echo '<td>Rp. ' . htmlspecialchars(number_format($row['totalHarga'], 0, ',', '.')) . '</td>';
                    echo '<td>';
                    echo '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#' . $modalId . '">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                              <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                              <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                            </svg>
                          </button> ';
                    echo '<a class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal' . $row['id'] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                              <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                            </svg></a>';
                    echo '</td>';
                    echo '</tr>';

                    // Modal
                    echo '<div class="modal fade" id="' . $modalId . '" tabindex="-1" aria-labelledby="modalLabel' . $row['id'] . '" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="background-color: #333;">
                                    <div class="modal-header" style="background-color: #191E2B;">
                                        <h5 class="modal-title" id="modalLabel' . $row['id'] . '" style="color: #fff;">Detail Booking</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="color: #fff;">
                                        <p><strong>Nama:</strong> ' . htmlspecialchars($row['name']) . '</p>
                                        <p><strong>Email:</strong> ' . htmlspecialchars($row['email']) . '</p>
                                        <p><strong>Telepon:</strong> ' . htmlspecialchars($row['phone']) . '</p>
                                        <p><strong>Tanggal Mulai:</strong> ' . htmlspecialchars($row['startDate']) . '</p>
                                        <p><strong>Tanggal Selesai:</strong> ' . htmlspecialchars($row['endDate']) . '</p>
                                        <p><strong>Total Biaya:</strong> Rp. ' . htmlspecialchars(number_format($row['totalHarga'], 0, ',', '.')) . '</p>
                                        <p><strong>Detail Paket:</strong></p>
                                        <ul>';
                                        $paket = json_decode($row['paket'], true);
                                        if (!empty($paket)) {
                                            echo '<li>' . htmlspecialchars($paket['nama_paket']) . ' - Rp. ' . htmlspecialchars(number_format($paket['harga'], 0, ',', '.')) . '</li>';
                                            echo '<ul id="deskripsiPaket">';
                                            $deskripsi_decoded = json_decode($paket['deskripsi'], true);
                                            foreach ($deskripsi_decoded as $deskripsi_item) {
                                                echo '<li>' . htmlspecialchars($deskripsi_item) . '</li>';
                                            }
                                            echo '</ul>';
                                        } else {
                                            echo '<li>Tidak ada paket yang termasuk.</li>';
                                        }
                                        echo '</ul>
                                        <p><strong>Detail Layanan:</strong></p>
                                        <ul>';
                                        $layanan = json_decode($row['layanan'], true);
                                        if(!empty($layanan)){
                                            foreach($layanan as $item){
                                                echo '<li>' . htmlspecialchars($item['nama_layanan']) . ' - Rp. ' . htmlspecialchars(number_format($item['harga'], 0, ',', '.')) . '</li>';
                                            }
                                        } else {
                                            echo '<li>Tidak ada layanan yang termasuk.</li>';
                                        }
                    echo                '</ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>';
                echo '<div class="modal fade" id="deleteModal' . $row['id'] . '" tabindex="-1" aria-labelledby="deleteModalLabel' . $row['id'] . '" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content" style="background-color: #333;">
                                <div class="modal-header" style="background-color: #191E2B;">
                                    <h5 class="modal-title" id="deleteModalLabel' . $row['id'] . '" style="color: #fff;">Konfirmasi Hapus Booking</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="color: #fff;">
                                    <p>Apakah Anda yakin ingin menghapus booking atas nama <strong>' . htmlspecialchars($row['name']) . '</strong> ini?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <form action="/admin/booking?method=DELETE" method="POST">
                                        <input type="hidden" name="id" value="' . $row['id'] . '">
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<div class="text-center py-5">';
                echo '<i class="fas fa-inbox fa-3x mb-3" style="color: #ddd;"></i>';
                echo '<p style="color: #ddd;">Tidak ada booking.</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>