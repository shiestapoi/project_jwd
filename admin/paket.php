<?php
include '../middleware/mysql.php';
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: /admin/login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nama_paket = $_POST['nama_paket'] ?? null;
    $harga = $_POST['harga'] ?? null;
    $deskripsi = $_POST['deskripsi'] ?? null;

    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'delete' && $id) {
            $stmt = $conn->prepare("DELETE FROM paket WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            header("Location: /admin/paket?message='Berhasil menghapus paket'");
            exit();
        } elseif ($_POST['action'] === 'add' && $nama_paket && $harga && $deskripsi) {
            $stmt = $conn->prepare("INSERT INTO paket (nama_paket, harga, deskripsi) VALUES (?, ?, ?)");
            $stmt->bind_param("sis", $nama_paket, $harga, json_encode($deskripsi));
            $stmt->execute();
            header("Location: /admin/paket?message='Berhasil menambah paket'");
            exit();
        } elseif ($_POST['action'] === 'edit' && $id && $nama_paket && $harga && $deskripsi) {
            $stmt = $conn->prepare("UPDATE paket SET nama_paket = ?, harga = ?, deskripsi = ? WHERE id = ?");
            $stmt->bind_param("sisi", $nama_paket, $harga, json_encode($deskripsi), $id);
            $stmt->execute();
            header("Location: /admin/paket?message='Berhasil mengedit paket'");
            exit();
        }
    }
}

$stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$title = 'Paket';
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
            <h1 style="color: #fff;">Daftar Paket</h1>
        </div>
        <div class="card-body p-0" style="background-color: #2C3E50;">
            <button class="btn btn-success m-3" data-bs-toggle="modal" data-bs-target="#addModal"
                style="background-color: #28a745; border: none;">Tambah Paket</button>
            <?php
            $query = "SELECT * FROM paket ORDER BY id ASC";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                echo '<table class="table table-dark table-hover">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>ID</th>';
                echo '<th>Nama Paket</th>';
                echo '<th>Harga</th>';
                echo '<th>Deskripsi</th>';
                echo '<th>Aksi</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['nama_paket']) . '</td>';
                    echo '<td>Rp. ' . htmlspecialchars(number_format($row['harga'], 0, ',', '.')) . '</td>';
                    echo '<td>';
                    $deskripsi = json_decode($row['deskripsi'], true);
                    echo '<ul id="deskripsiPaket">';
                    foreach ($deskripsi as $item) {
                        echo '<li>' . htmlspecialchars($item) . '</li>';
                    }
                    echo '</ul>';
                    echo '</td>';
                    echo '<td>';
                    echo '<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" data-id="' . $row['id'] . '" data-nama_paket="' . htmlspecialchars($row['nama_paket']) . '" data-harga="' . htmlspecialchars($row['harga']) . '" data-deskripsi="' . htmlspecialchars(json_encode($deskripsi)) . '">Edit</button> ';
                    echo '<button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $row['id'] . ')">Hapus</button>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<div class="text-center py-5">';
                echo '<i class="fas fa-inbox fa-3x mb-3" style="color: #ddd;"></i>';
                echo '<p style="color: #ddd;">Tidak ada paket.</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>

<!-- Modal Tambah Paket -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #1E1E1E;">
            <form method="POST" action="/admin/paket">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Paket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="color: #fff;"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="add">
                    <div class="mb-3">
                        <label for="nama_paket" class="form-label">Nama Paket</label>
                        <input type="text" class="form-control" id="nama_paket" name="nama_paket" required
                            style="background-color: #333; color: #fff; border: none;">
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" required
                            style="background-color: #333; color: #fff; border: none;">
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <div id="deskripsiContainer">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="deskripsi[]" required
                                    style="background-color: #333; color: #fff; border: none;">
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="tambahDeskripsi('add')"><svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                            </svg></button>
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

<!-- Modal Edit Paket -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #1E1E1E;">
            <form method="POST" action="/admin/paket">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Paket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3">
                        <label for="edit_nama_paket" class="form-label">Nama Paket</label>
                        <input type="text" class="form-control" id="edit_nama_paket" name="nama_paket" required
                            style="background-color: #333; color: #fff; border: none;">
                    </div>
                    <div class="mb-3">
                        <label for="edit_harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="edit_harga" name="harga" required
                            style="background-color: #333; color: #fff; border: none;">
                    </div>
                    <div class="mb-3">
                        <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                        <div id="editDeskripsiContainer">
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="tambahDeskripsi('edit')"><svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                            </svg></button>
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
    if (confirm("Apakah Anda yakin ingin menghapus paket ini?")) {
        var form = document.createElement("form");
        form.method = "POST";
        form.action = "/admin/paket";
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
    var nama_paket = button.getAttribute('data-nama_paket');
    var harga = button.getAttribute('data-harga');
    var deskripsi = JSON.parse(button.getAttribute('data-deskripsi'));

    var modal = this;
    modal.querySelector('#edit_id').value = id;
    modal.querySelector('#edit_nama_paket').value = nama_paket;
    modal.querySelector('#edit_harga').value = harga;

    var container = modal.querySelector('#editDeskripsiContainer');
    container.innerHTML = '';
    if (deskripsi.length === 0) {
        tambahDeskripsi('edit', true);
    } else {
        deskripsi.forEach(function(item) {
            tambahDeskripsi('edit', false, item);
        });
    }
});

function tambahDeskripsi(mode, isDefault = false, value = '') {
    var container = document.getElementById(mode === 'add' ? 'deskripsiContainer' : 'editDeskripsiContainer');
    var div = document.createElement('div');
    div.className = 'input-group mb-2';
    var input = document.createElement('input');
    input.type = 'text';
    input.className = 'form-control';
    input.name = 'deskripsi[]';
    input.required = true;
    input.value = value;
    input.style = 'background-color: #333; color: #fff; border: none;';
    div.appendChild(input);
    if (!isDefault) {
        var button = document.createElement('button');
        button.type = 'button';
        button.className = 'btn btn-danger';
        button.textContent = 'Hapus';
        button.onclick = function() {
            hapusDeskripsi(this);
        };
        div.appendChild(button);
    }
    container.appendChild(div);
}

function hapusDeskripsi(button) {
    var container = button.closest('.modal-body').querySelector('[id$="DeskripsiContainer"]');
    button.parentElement.remove();
    if (container.children.length === 0) {
        tambahDeskripsi(container.id === 'editDeskripsiContainer' ? 'edit' : 'add', true);
    }
}
</script>

<?php include 'components/footer.php'; ?>