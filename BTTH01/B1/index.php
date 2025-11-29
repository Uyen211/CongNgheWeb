
<?php
require 'flowers.php';
// Kiểm tra xem người dùng đang ở chế độ nào (mặc định là guest)
$is_admin = isset($_GET['mode']) && $_GET['mode'] == 'admin';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách các loài hoa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .flower-card { margin-bottom: 40px; }
        .flower-title { font-weight: bold; color: #333; margin-bottom: 10px; }
        .flower-desc { text-align: justify; margin-bottom: 20px; }
        .flower-img { width: 100%; height: auto; border-radius: 5px; object-fit: cover; }
        .admin-thumb { width: 80px; height: 60px; object-fit: cover; margin-right: 5px; }
        .flower { width: 100%; height: auto; margin-bottom: 30px; border-radius: 5px; object-fit: cover; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="?mode=guest">My Flowers</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link <?= !$is_admin ? 'active' : '' ?>" href="?mode=guest">Giao diện Khách</a>
            <a class="nav-link <?= $is_admin ? 'active' : '' ?>" href="?mode=admin">Quản trị (Admin)</a>
        </div>
    </div>
</nav>

<div class="container">
    <?php if ($is_admin): ?>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-primary">Quản trị danh sách hoa</h2>
            <button class="btn btn-success">Thêm mới</button>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" style="width: 20%;">Tên hoa</th>
                        <th scope="col" style="width: 40%;">Mô tả</th>
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($flowers as $index => $flower): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td class="fw-bold"><?= $flower['name'] ?></td>
                        <td><?= $flower['description'] ?></td>
                        <td>
                            <?php foreach ($flower['images'] as $img): ?>
                                <img src="<?= $img ?>" class="admin-thumb" alt="Ảnh hoa">
                            <?php endforeach; ?>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary mb-1"><i class="bi bi-pencil"></i> Sửa</button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Xóa</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php else: ?>
        <h1 class="text-center text-success mb-5">14 loại hoa tuyệt đẹp thích hợp trồng dịp xuân hè</h1>
        
        <div class="row justify-content-center">
            <div class="col-md-8"> 
            <p>Mỗi loại hoa sẽ khoe sắc rực rỡ vào đúng thời điểm thích hợp trong năm, khí hậu đáp ứng thuận lợi sẽ giúp hoa phát triển nhanh và đẹp một cách hoàn hảo. 
                        Nếu đang có kế hoạch trồng hoa trong dịp xuân - hè thì bạn hãy tham khảo bài viết dưới đây nhé!</p>
            <img src="<?= 'images/image.png' ?>" class="flower" alt="<?= 'hoa' ?>">

            
            <?php foreach ($flowers as $index => $flower): ?>
                    <div class="flower-card">
                        <h4 class="flower-title"><?= ($index + 1) . '. ' . $flower['name'] ?></h4>
                        
                        <p class="flower-desc"><?= $flower['description'] ?></p>
                        
                        <div class="row">
                            <?php foreach ($flower['images'] as $img): ?>
                                <div class="col-12 mb-3">
                                    <img src="<?= $img ?>" class="flower-img" alt="<?= $flower['name'] ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>