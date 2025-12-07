
<?php
// models/SinhVienModel.php

// Hàm lấy tất cả sinh viên
// TODO 1: Viết 1 hàm tên là getAllSinhVien()
function getAllSinhVien($pdo) {
    // SQL Select
    $sql = "SELECT * FROM sinhvien ORDER BY id ASC"; 
    $stmt = $pdo->query($sql);
    
    // Trả về mảng kết hợp
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Hàm thêm sinh viên mới
// TODO 2: Viết 1 hàm tên là addSinhVien()
function addSinhVien($pdo, $ten, $email) {
    // SQL Insert dùng Prepared Statement để tránh SQL Injection
    $sql = "INSERT INTO sinhvien (ten_sinh_vien, email) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    
    // Thực thi câu lệnh
    return $stmt->execute([$ten, $email]);
}
?>