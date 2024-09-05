<?php
include '../middleware/mysql.php';
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: /admin/login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nama_layanan = $_POST['nama_layanan'] ?? null;
    $harga = $_POST['harga'] ?? null;

    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'delete' && $id) {
            $stmt = $conn->prepare("DELETE FROM layanan WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            header("Location: /admin/layanan?message='Berhasil menghapus layanan'");
            exit();
        } elseif ($_POST['action'] === 'add' && $nama_layanan && $harga) {
            $stmt = $conn->prepare("INSERT INTO layanan (nama_layanan, harga) VALUES (?, ?)");
            $stmt->bind_param("si", $nama_layanan, $harga);
            $stmt->execute();
            header("Location: /admin/layanan?message='Berhasil menambah layanan'");
            exit();
        } elseif ($_POST['action'] === 'edit' && $id && $nama_layanan && $harga) {
            $stmt = $conn->prepare("UPDATE layanan SET nama_layanan = ?, harga = ? WHERE id = ?");
            $stmt->bind_param("sii", $nama_layanan, $harga, $id);
            $stmt->execute();
            header("Location: /admin/layanan?message='Berhasil mengedit layanan'");
            exit();
        }
    }
}

$stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$title = 'Layanan';
include 'components/header.php';
?>
<div class="container mb-5" style="margin-top: 100px;">
    <div class="card" style="background-color: #333;">
        <div class="card-header" style="background-color: #191E2B;">
            <h1 style="color: #fff;">Daftar Layanan</h1>
        </div>
        <div class="card-body p-0" style="background-color: #2C3E50;">
            <button class="btn btn-success m-3" data-bs-toggle="modal" data-bs-target="#addModal"
                style="background-color: #28a745; border: none;">Tambah Layanan</button>
            <?php
            $query = "SELECT * FROM layanan ORDER BY id ASC";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                echo '<table class="table table-dark table-hover">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>ID</th>';
                echo '<th>Nama Layanan</th>';
                echo '<th>Harga</th>';
                echo '<th>Aksi</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['nama_layanan']) . '</td>';
                    echo '<td>Rp. ' . htmlspecialchars(number_format($row['harga'], 0, ',', '.')) . '</td>';
                    echo '<td>';
                    echo '<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" data-id="' . $row['id'] . '" data-nama_layanan="' . htmlspecialchars($row['nama_layanan']) . '" data-harga="' . htmlspecialchars($row['harga']) . '">Edit</button> ';
                    echo '<button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $row['id'] . ')">Hapus</button>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<div class="text-center py-5">';
                echo '<i class="fas fa-inbox fa-3x mb-3" style="color: #ddd;"></i>';
                echo '<p style="color: #ddd;">Tidak ada layanan.</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>

<!-- Modal Tambah Layanan -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #1E1E1E;">
            <form method="POST" action="/admin/layanan">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Layanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="color: #fff;"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="add">
                    <div class="mb-3">
                        <label for="nama_layanan" class="form-label">Nama Layanan</label>
                        <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" required
                            style="background-color: #333; color: #fff; border: none;">
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" required
                            style="background-color: #333; color: #fff; border: none;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Layanan -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #1E1E1E;">
            <form method="POST" action="/admin/layanan">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Layanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3">
                        <label for="edit_nama_layanan" class="form-label">Nama Layanan</label>
                        <input type="text" class="form-control" id="edit_nama_layanan" name="nama_layanan" required
                            style="background-color: #333; color: #fff; border: none;">
                    </div>
                    <div class="mb-3">
                        <label for="edit_harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="edit_harga" name="harga" required
                            style="background-color: #333; color: #fff; border: none;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    if (confirm("Apakah Anda yakin ingin menghapus layanan ini?")) {
        var form = document.createElement("form");
        form.method = "POST";
        form.action = "/admin/layanan";
        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "id";
        input.value = id;
        form.appendChild(input);
        var action = document.createElement("input");
        action.type = "hidden";
        action.name = "action";
        action.value = "delete";
        form.appendChild(action);
        document.body.appendChild(form);
        form.submit();
    }
}

document.getElementById('editModal').addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget;
    var id = button.getAttribute('data-id');
    var nama_layanan = button.getAttribute('data-nama_layanan');
    var harga = button.getAttribute('data-harga');

    var modal = this;
    modal.querySelector('#edit_id').value = id;
    modal.querySelector('#edit_nama_layanan').value = nama_layanan;
    modal.querySelector('#edit_harga').value = harga;
});
</script>

<?php include 'components/footer.php'; ?>