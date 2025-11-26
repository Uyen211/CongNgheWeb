<?php
// Bước 1: Gọi file data.php chứa mảng dữ liệu (giả lập CSDL)
// Lưu ý: Biến $do_an_list phải được định nghĩa trong file data.php này
require("data.php");

// Bước 2: Nhận thông báo thành công (nếu có)
$success = $_GET['success'] ?? "";
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Quản lý Đồ án</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="navbar">
    <div>Quản lý Đồ án Tốt nghiệp</div>
    <div>
        <a href="index.php">Dashboard</a>
        <a href="create.php" class="btn btn-primary">+ Thêm đồ án</a>
    </div>
</div>

<div class="container">
    <h1>Dashboard</h1>
    <p>Dữ liệu trong ví dụ này đang được lưu cố định trong một mảng PHP.</p>

    <?php if ($success == "created"): ?>
        <div class="alert-success">
            Giả lập: Thêm đồ án mới thành công!
        </div>
    <?php endif; ?>

    <table class="table" border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse;">
        <thead>
        <tr style="background-color: #f2f2f2;">
            <th>#</th>
            <th>Tên đề tài</th>
            <th>Sinh viên</th>
            <th>GV hướng dẫn</th>
            <th>Năm học</th>
            <th>Trạng thái</th>
            <th>Ngày tạo</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($do_an_list)): ?>
            
            <?php foreach ($do_an_list as $item): ?>
            <tr>
                <td><?php echo $item['id']; ?></td>
                <td><?php echo $item['ten_de_tai']; ?></td>
                <td><?php echo $item['ten_sinh_vien']; ?></td>
                <td><?php echo $item['giang_vien_hd']; ?></td>
                <td><?php echo $item['nam_hoc']; ?></td>
                <td><?php echo $item['trang_thai']; ?></td>
                <td><?php echo $item['created_at']; ?></td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="7" style="text-align:center">Chưa có đồ án nào trong danh sách.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>