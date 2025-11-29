<?php
class Quiz {
    private $conn;

    // Constructor nhận kết nối DB [cite: 669]
    public function __construct($db) {
        $this->conn = $db;
    }

// 1. Hàm đọc file TXT và lưu vào Database
    public function importQuestionsFromTextFile($filePath) {
        // Đọc file
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        // Làm sạch bảng cũ trước khi thêm mới (tùy chọn)
        $this->conn->exec("TRUNCATE TABLE questions");

        $currentQuestion = [
            'question_text' => '',
            'options' => [],
            'answer' => ''
        ];

        // Chuẩn bị câu lệnh SQL (Prepared Statement)
        $sql = "INSERT INTO questions (question_text, option_a, option_b, option_c, option_d, answer) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        foreach ($lines as $line) {
            $line = trim($line);
            
            // Logic phân tích cú pháp 
            if (strpos($line, 'ANSWER:') === 0) {
                $answer = trim(substr($line, strpos($line, ':') + 1));
                
                // Khi tìm thấy đáp án, nghĩa là đã xong 1 câu -> Lưu vào DB
                // Đảm bảo có đủ 4 đáp án để tránh lỗi
                $optA = $currentQuestion['options']['A'] ?? '';
                $optB = $currentQuestion['options']['B'] ?? '';
                $optC = $currentQuestion['options']['C'] ?? '';
                $optD = $currentQuestion['options']['D'] ?? '';

                $stmt->execute([
                    trim($currentQuestion['question_text']),
                    $optA, $optB, $optC, $optD, $answer
                ]);

                // Reset biến tạm
                $currentQuestion = [
                    'question_text' => '',
                    'options' => [],
                    'answer' => ''
                ];
            } elseif (preg_match('/^([A-D])\./', $line, $matches)) {
                $currentQuestion['options'][$matches[1]] = $line;
            } else {
                $currentQuestion['question_text'] .= $line . " "; 
            }
        }
    }

    // 2. Hàm lấy danh sách câu hỏi từ Database ra để hiển thị
    public function getQuestionsFromDB() {
        $stmt = $this->conn->query("SELECT * FROM questions");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $formattedQuestions = [];

        // Chuyển đổi định dạng từ DB về định dạng mảng mà file index.php cũ đang dùng
        // Để không phải sửa quá nhiều code hiển thị HTML
        foreach ($rows as $row) {
            $formattedQuestions[] = [
                'question_text' => $row['question_text'],
                'options' => [
                    'A' => $row['option_a'],
                    'B' => $row['option_b'],
                    'C' => $row['option_c'],
                    'D' => $row['option_d']
                ],
                'answer' => $row['answer']
            ];
        }

        return $formattedQuestions;
    }
}
?>