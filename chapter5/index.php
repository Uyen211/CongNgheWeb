<?php
// index.php

// TODO 6: Import Model
require_once 'models/SinhVienModel.php';

// === THIẾT LẬP KẾT NỐI PDO ===
// Cấu hình DB
$host = '127.0.0.1';
$dbname = 'cse485_web'; // Theo yêu cầu của bạn
$username = 'root';
$password = ''; // XAMPP mặc định pass rỗng

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}
// === KẾT THÚC KẾT NỐI PDO ===

// === LOGIC CỦA CONTROLLER ===

// TODO 8: Kiểm tra hành động POST (Thêm sinh viên)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ten_sinh_vien'])) {
    
    // TODO 9: Lấy dữ liệu từ form
    $ten = $_POST['ten_sinh_vien'];
    $email = $_POST['email'];

    // TODO 10: Gọi hàm addSinhVien từ Model
    // Controller ra lệnh cho Model thực hiện ghi vào DB
    addSinhVien($pdo, $ten, $email);

    // TODO 11: Chuyển hướng để làm mới trang (PRG Pattern)
    header('Location: index.php');
    exit;
}

// TODO 12: Luôn gọi hàm lấy danh sách
// Controller yêu cầu Model lấy dữ liệu thô
$danh_sach_sv = getAllSinhVien($pdo);

// TODO 13: Import View ở cuối cùng
// View sẽ sử dụng biến $danh_sach_sv ở trên để hiển thị
include 'views/sinhvien_view.php';
?>