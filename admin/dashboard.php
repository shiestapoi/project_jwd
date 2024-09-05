<?php 
include '../middleware/mysql.php';
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: /admin/login');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$title = 'Inbox';
include 'components/header.php';
?>
<div class="container mb-5" style="margin-top: 100px;">
    <div class="card" style="background-color: #333;">
        <div class="card-header" style="background-color: #191E2B;">
            <h1 style="color: #fff;">Inbox</h1>
        </div>
        <div class="card-body p-0">
            <?php
    $query = "SELECT * FROM contactme ORDER BY reg_date DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo '<div class="list-group list-group-flush">';
        while ($row = $result->fetch_assoc()) {
            $date = new DateTime($row['reg_date']);
            echo '<div class="list-group-item border-0 border-bottom border-light-subtle py-4" style="background-color: #2c2c2c; transition: all 0.3s;">';
            echo '<div class="d-flex justify-content-between align-items-center mb-2">';
            echo '<h5 class="mb-0 text-primary">' . htmlspecialchars($row['subject']) . '</h5>';
            echo '<span class="badge bg-secondary rounded-pill">' . $date->format('d M Y') . '</span>';
            echo '</div>';
            echo '<p class="mb-2 text-light">' . htmlspecialchars($row['message']) . '</p>';
            echo '<div class="d-flex justify-content-between align-items-center">';
            echo '<small style="color: #ddd;">From: ' . htmlspecialchars($row['name']) . ' (' . htmlspecialchars($row['email']) . ')</small>';
            echo '<a href="mailto:' . htmlspecialchars($row['email']) . '" class="btn btn-outline-primary btn-sm">Reply</a>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<div class="text-center py-5">';
        echo '<i class="fas fa-inbox fa-3x mb-3" style="color: #ddd;"></i>';
        echo '<p style="color: #ddd;">Tidak ada pesan.</p>';
        echo '</div>';
    }
    ?>
        </div>
    </div>
</div>
<?php include 'components/footer.php'; ?>