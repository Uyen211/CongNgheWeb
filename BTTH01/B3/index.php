<?php
$filename = '65HTTT_Danh_sach_diem_danh.csv';
$users = [];
$headers = [];

// Kiểm tra file có tồn tại không
if (file_exists($filename)) {
    // Mở file ở chế độ đọc ('r')
    if (($handle = fopen($filename, "r")) !== FALSE) {
        
        // Đọc dòng đầu tiên để lấy tên cột (Header)
        // fgetcsv sẽ trả về mảng các cột
        //$length = 1000, ký tự tối đa để đọc trong một dòng
        // Đọc dòng đầu tiên để lấy tên cột (Header)
        if (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // XỬ LÝ QUAN TRỌNG: Loại bỏ BOM và khoảng trắng thừa
            $headers = array_map(function($item) {
                // Xóa các ký tự BOM đầu file (thường là \xEF\xBB\xBF) và khoảng trắng
                $item = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $item);
                return trim($item);
            }, $data);
        }

        // Đọc các dòng dữ liệu còn lại
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Kết hợp header và data để tạo mảng liên hợp cho dễ xử lý (key => value)
            // Ví dụ: ['username' => '235...', 'lastname' => 'Đinh...']
            // Cần kiểm tra số lượng cột có khớp không để tránh lỗi
            if (count($headers) == count($data)) {
                $users[] = array_combine($headers, $data);
            }
        }
        
        fclose($handle);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center text-primary mb-4">Danh sách điểm danh lớp 65HTTT</h2>
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-success">
            <i class="bi bi-person-plus-fill"></i> Thêm sinh viên mới
        </button>
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Tìm kiếm..." aria-label="Search">
            <button class="btn btn-outline-primary" type="submit">Tìm</button>
        </form>
    </div>

    <?php if (empty($users)): ?>
        <div class="alert alert-warning">Không tìm thấy dữ liệu hoặc file không tồn tại.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Tên tài khoản</th>
                        <th>Mật khẩu</th>
                        <th>Họ đệm</th>
                        <th>Tên</th>
                        <th>Lớp</th>
                        <th>Email</th>
                        <th>Khóa học</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $index => $user): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td class="fw-bold"><?= $user['username'] ?? '' ?></td>
                            <td class="fw-bold"><?= $user['password'] ?? '' ?></td>
                            <td><?= $user['lastname'] ?? '' ?></td>
                            <td><?= $user['firstname'] ?? '' ?></td>
                            <td><span class="badge bg-info text-dark"><?= $user['city'] ?? '' ?></span></td>
                            <td><?= $user['email'] ?? '' ?></td>
                            <td><?= $user['course1'] ?? '' ?></td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm me-1" title="Sửa">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?');">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
       
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>