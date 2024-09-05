<?php
include '../middleware/mysql.php';
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: /admin/login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_SESSION['id'];
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;
    $confirm_password = $_POST['confirm_password'] ?? null;

    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'edit_username' && $username) {
            $stmt = $conn->prepare("UPDATE user SET username = ? WHERE id = ?");
            $stmt->bind_param("si", $username, $id);
            $stmt->execute();
            $_SESSION['username'] = $username;
            header("Location: /admin/profile?message=Berhasil mengubah username");
            exit();
        } elseif ($_POST['action'] === 'edit_password' && $password && $confirm_password) {
            if ($password === $confirm_password) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE user SET password = ? WHERE id = ?");
                $stmt->bind_param("si", $hashed_password, $id);
                $stmt->execute();
                header("Location: /admin/profile?message=Berhasil mengubah password");
                exit();
            } else {
                $error = "Password dan konfirmasi password tidak cocok";
            }
        }
    }
}

$stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$title = 'Profil';
include 'components/header.php';
?>
<div class="container mb-5" style="margin-top: 100px;">
    <div class="card" style="background-color: #333;">
        <div class="card-header" style="background-color: #191E2B;">
            <h1 style="color: #fff;">Profil Pengguna</h1>
        </div>
        <div class="card-body" style="background-color: #2C3E50;">
            <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card" style="background-color: #1E1E1E;">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #fff;">Username</h5>
                            <p class="card-text" style="color: #ddd;"><?php echo htmlspecialchars($user['username']); ?>
                            </p>
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editUsernameModal">Ubah Username</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card" style="background-color: #1E1E1E;">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #fff;">Password</h5>
                            <p class="card-text" style="color: #ddd;">********</p>
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editPasswordModal">Ubah Password</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ubah Username -->
<div class="modal fade" id="editUsernameModal" tabindex="-1" aria-labelledby="editUsernameModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #1E1E1E;">
            <form method="POST" action="/admin/profile">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUsernameModalLabel" style="color: #fff;">Ubah Username</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit_username">
                    <div class="mb-3">
                        <label for="username" class="form-label" style="color: #fff;">Username Baru</label>
                        <input type="text" class="form-control" id="username" name="username" required
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

<!-- Modal Ubah Password -->
<div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #1E1E1E;">
            <form method="POST" action="/admin/profile">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPasswordModalLabel" style="color: #fff;">Ubah Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit_password">
                    <div class="mb-3">
                        <label for="password" class="form-label" style="color: #fff;">Password Baru</label>
                        <input type="password" class="form-control" id="password" name="password" required
                            style="background-color: #333; color: #fff; border: none;">
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label" style="color: #fff;">Konfirmasi Password
                            Baru</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                            required style="background-color: #333; color: #fff; border: none;">
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

<?php include 'components/footer.php'; ?>