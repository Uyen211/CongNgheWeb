<?php
session_start();

require 'db.php';
require 'user.php';

$database = new Database();
$db = $database->getConnection();
$userObj = new User($db);

// --- XỬ LÝ 1: UPLOAD FILE (Sửa lỗi lặp dữ liệu) ---
if (isset($_POST['btn_upload'])) {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $fileName = $_FILES['csv_file']['tmp_name'];
        if ($userObj->importDataFromCSV($fileName)) {
            // Lưu thông báo vào session
            $_SESSION['message'] = '<div class="alert alert-success">Import thành công!</div>';
        } else {
            $_SESSION['message'] = '<div class="alert alert-danger">Import thất bại.</div>';
        }
    }
    // QUAN TRỌNG: Redirect về chính trang này để xóa trạng thái POST
    // Giúp F5 không bị gửi lại dữ liệu cũ
    header("Location: index.php");
    exit();
}

// --- XÓA TẤT CẢ DỮ LIỆU (Reset ID về 1) ---
if (isset($_POST['btn_delete_all'])) {
    if ($userObj->deleteAllData()) {
        $_SESSION['message'] = '<div class="alert alert-warning">Đã xóa toàn bộ dữ liệu và reset ID!</div>';
    } else {
        $_SESSION['message'] = '<div class="alert alert-danger">Xóa thất bại.</div>';
    }
    // Redirect để tránh F5 bị xóa lại (dù xóa lại cũng không sao nhưng đúng chuẩn PRG)
    header("Location: index.php");
    exit();
}

// Lấy danh sách user
$users = $userObj->getAllUsers();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Điểm danh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center text-primary mb-4">Danh sách Sinh viên</h2>

    <?php 
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']); // Xóa thông báo sau khi hiện để F5 không hiện lại
    }
    ?>

    <div class="card p-4 mb-4 shadow-sm bg-light">
        <div class="d-flex justify-content-between align-items-center">
            
            <form method="POST" enctype="multipart/form-data" class="d-flex gap-2">
                <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                <button type="submit" name="btn_upload" class="btn btn-success">Upload File</button>
            </form>

            <form method="POST" onsubmit="return confirm('Bạn có chắc muốn XÓA SẠCH dữ liệu? ID sẽ được reset về 1.');">
                <button type="submit" name="btn_delete_all" class="btn btn-danger">Xóa tất cả & Reset ID</button>
            </form>

        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Họ đệm</th>
                    <th>Tên</th>
                    <th>Lớp</th>
                    <th>Email</th>
                    <th>Khóa học</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($users) > 0): ?>
                    <?php foreach ($users as $row): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['lastname']) ?></td>
                        <td><?= htmlspecialchars($row['firstname']) ?></td>
                        <td><?= htmlspecialchars($row['city']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['course1']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center">Chưa có dữ liệu</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>