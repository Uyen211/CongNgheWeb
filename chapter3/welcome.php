<?php

// Khởi động session (bắt buộc)
session_start();

// Kiểm tra xem SESSION lưu tên đăng nhập có tồn tại không
// (tên khóa session phải khớp với tên bạn đã dùng khi tạo session ở trang đăng nhập)
if (isset($_SESSION['username'])) {
    // Lấy username từ SESSION và escape để tránh XSS
    $loggedInUser = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');

    // In ra lời chào mừng
    echo "<h1>Chào mừng trở lại, $loggedInUser!</h1>";
    echo "<p>Bạn đã đăng nhập thành công.</p>";

    // (Tạm thời) link để "Đăng xuất" — quay về login.html
    echo '<p><a href="login.html">Đăng xuất (Tạm thời)</a></p>';
} else {
    // Nếu không tồn tại SESSION (chưa đăng nhập) -> chuyển hướng về login.html
    header('Location: login.html');
    exit;
}
?>