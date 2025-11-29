<?php
class Flower {
    private $conn;
    private $table_name = "flowers";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Hàm lấy tất cả hoa và ảnh của chúng
    public function getAllFlowers() {
        // Query nối bảng flowers và flower_images
        $query = "SELECT f.id, f.name, f.description, i.image_path 
                  FROM " . $this->table_name . " f
                  LEFT JOIN flower_images i ON f.id = i.flower_id
                  ORDER BY f.id ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Xử lý dữ liệu thô từ SQL thành mảng cấu trúc mong muốn
        // Vì SQL trả về nhiều dòng cho 1 hoa (nếu có nhiều ảnh), ta cần gom nhóm lại.
        $flowers = [];
        
        foreach ($result as $row) {
            $id = $row['id'];
            
            // Nếu hoa này chưa có trong mảng tạm, tạo mới
            if (!isset($flowers[$id])) {
                $flowers[$id] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'description' => $row['description'],
                    'images' => [] // Khởi tạo mảng ảnh rỗng
                ];
            }
            
            // Thêm đường dẫn ảnh vào mảng images
            if (!empty($row['image_path'])) {
                $flowers[$id]['images'][] = $row['image_path'];
            }
        }

        // Reset key của mảng để trả về dạng [0, 1, 2...] thay vì [1, 2, 4...]
        return array_values($flowers);
    }
}
?>