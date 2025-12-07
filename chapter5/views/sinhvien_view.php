<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>PHT Chương 5 - MVC</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { margin-bottom: 20px; border: 1px solid #ddd; padding: 20px; }
        input[type="text"], input[type="email"] { padding: 8px; width: 300px; margin-bottom: 10px; }
        button { padding: 8px 15px; background: #28a745; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Thêm Sinh Viên Mới (Kiến trúc MVC)</h2>
    <form method="POST" action="index.php">
        <label>Tên Sinh Viên:</label><br>
        <input type="text" name="ten_sinh_vien" required><br>
        
        <label>Email:</label><br>
        <input type="email" name="email" required><br>
        
        <button type="submit">Thêm Sinh Viên</button>
    </form>

    <h2>Danh Sách Sinh Viên (Kiến trúc MVC)</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Tên Sinh Viên</th>
            <th>Email</th>
            <th>Ngày Tạo</th>
        </tr>
        <?php
        // TODO 4: Dùng vòng lặp foreach duyệt qua biến $danh_sach_sv
        // Biến này được Controller truyền sang (không cần khởi tạo ở đây)
        if (isset($danh_sach_sv) && is_array($danh_sach_sv)) {
            foreach ($danh_sach_sv as $sv) {
                // TODO 5: In các dòng <tr> <td>
                // Sử dụng htmlspecialchars để ngăn chặn XSS
                echo "<tr>";
                echo "<td>" . htmlspecialchars($sv['id']) . "</td>";
                echo "<td>" . htmlspecialchars($sv['ten_sinh_vien']) . "</td>";
                echo "<td>" . htmlspecialchars($sv['email']) . "</td>";
                echo "<td>" . htmlspecialchars($sv['ngay_tao']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Không có dữ liệu sinh viên.</td></tr>";
        }
        ?>
    </table>
</body>
</html>