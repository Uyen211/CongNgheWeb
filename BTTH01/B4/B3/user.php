<?php
class User {
    private $conn;
    private $table_name = "users";

    // Constructor nhận kết nối DB [cite: 669]
    public function __construct($db) {
        $this->conn = $db;
    }

    // Hàm đọc file CSV và lưu vào CSDL
    public function importDataFromCSV($filePath) {
        if (!file_exists($filePath)) return false;

        try {
            $handle = fopen($filePath, "r");
            
            // Bỏ qua dòng tiêu đề (Header)
            fgetcsv($handle, 1000, ",");

            // Chuẩn bị câu lệnh SQL INSERT [cite: 674]
            $query = "INSERT INTO " . $this->table_name . " 
                      (username, password, lastname, firstname, city, email, course1) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // XỬ LÝ LỖI BOM (quan trọng để hiển thị username đúng)
                $username = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', trim($data[0]));
                
                // Thực thi lệnh insert [cite: 677]
                $stmt->execute([
                    $username,  // username đã xử lý sạch
                    $data[1],   // password
                    $data[2],   // lastname
                    $data[3],   // firstname
                    $data[4],   // city
                    $data[5],   // email
                    $data[6]    // course1
                ]);
            }
            fclose($handle);
            return true;

        } catch (PDOException $e) {
            // Hiển thị lỗi nếu có
            echo "Lỗi Import: " . $e->getMessage();
            return false;
        }
    }

    // Hàm lấy tất cả sinh viên (Giống getAllBooks trang 23) [cite: 679]
    public function getAllUsers() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(); // [cite: 681]
    }

    // THÊM HÀM MỚI NÀY: Xóa sạch dữ liệu và Reset ID về 1
    public function deleteAllData() {
        try {
            // TRUNCATE xóa nhanh hơn DELETE và tự động reset ID về 1
            $query = "TRUNCATE TABLE " . $this->table_name;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>