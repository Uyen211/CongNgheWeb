<?php

// Hàm đọc và phân tích file Quiz.txt
function getQuestions($filePath) {
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $questions = [];
    $currentQuestion = [
        'question_text' => '',
        'options' => [],
        'answer' => ''
    ];

    foreach ($lines as $line) {
        $line = trim($line);
        
        // Kiểm tra xem dòng có phải là đáp án đúng không (Bắt đầu bằng ANSWER:)
        if (strpos($line, 'ANSWER:') === 0) {
            //substr(string, start): lấy phần chuỗi từ vị trí start đến hết chuỗi
            $currentQuestion['answer'] = trim(substr($line, strpos($line, ':') + 1));
            $questions[] = $currentQuestion; // Lưu câu hỏi vào mảng tổng
            // Reset biến tạm để đón câu hỏi mới
            $currentQuestion = [
                'question_text' => '',
                'options' => [],
                'answer' => ''
            ];
        } 
        // Kiểm tra xem dòng có phải là các lựa chọn A, B, C, D không
        // matches[0] là toàn bộ chuỗi khớp, matches[1] là phần trong ngoặc đơn
        elseif (preg_match('/^([A-D])\./', $line, $matches)) {
            // Lưu nội dung lựa chọn vào mảng options
            $currentQuestion['options'][$matches[1]] = $line;
        } 
        // Nếu không phải 2 trường hợp trên thì là nội dung câu hỏi
        else {
            // Nối chuỗi phòng trường hợp câu hỏi xuống dòng
            $currentQuestion['question_text'] .= $line . " "; 
        }
    }
    return $questions;
}

// Lấy danh sách câu hỏi
$questions = getQuestions('Quiz.txt');

// Xử lý khi người dùng nhấn nộp bài
$score = null;
$submitted = false;
$user_answers = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $submitted = true;
    $score = 0;
    $user_answers = $_POST['answers'] ?? []; // Lấy các đáp án người dùng chọn

    foreach ($questions as $index => $q) {
        // Kiểm tra đáp án người dùng so với đáp án đúng
        if (isset($user_answers[$index]) && $user_answers[$index] === $q['answer']) {
            $score++;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài thi trắc nghiệm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .question-card {
            background: #effcffff;
            border-radius: 8px;
            box-shadow: 10px 10px 10px rgba(0, 187, 255, 1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .question-text { font-weight: bold; font-size: 1.1rem; margin-bottom: 15px; color: #1500ffff;}
        .form-check-label { cursor: pointer; width: 100%; }
        
        /* CSS tô màu khi nộp bài */
        .correct-answer { background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; }
        .wrong-answer { background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; }
        .correct-highlight { color: #155724; font-weight: bold; }
        .options-list { margin-left: 20px; }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="text-center mb-4 text-primary">TRẮC NGHIỆM KIẾN THỨC</h2>

    <?php if ($submitted): ?>
        <div class="alert alert-info text-center">
            <h4>Kết quả: <?= $score ?> / <?= count($questions) ?> câu đúng</h4>
            <a href="index.php" class="btn btn-secondary btn-lg ms-2">Làm lại</a> 

        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <?php foreach ($questions as $index => $q): ?>
            <div class="question-card">
                <div class="question-text">Câu <?= $index + 1 ?>: <?= $q['question_text'] ?></div>
                
                <div class="options-list">
                    <?php foreach ($q['options'] as $key => $option_text): ?>
                        <?php 
                            $class_result = "";
                            $is_checked = (isset($user_answers[$index]) && $user_answers[$index] === $key) ? 'checked' : '';
                            
                            if ($submitted) {
                                if ($key === $q['answer']) {
                                    $class_result = "correct-answer"; 
                                } elseif ($is_checked && $key !== $q['answer']) {
                                    $class_result = "wrong-answer";
                                }
                            }
                        ?>

                        <div class="form-check d-flex align-items-center mb-2 p-2 <?= $class_result ?>">
                            
                            <input class="form-check-input me-2" type="radio" 
                                name="answers[<?= $index ?>]" 
                                id="q<?= $index ?>_<?= $key ?>" 
                                value="<?= $key ?>" 
                                <?= $is_checked ?>
                                style="margin-top: 0;"> <label class="form-check-label" for="q<?= $index ?>_<?= $key ?>">
                                <?= $option_text ?>
                                <?php if ($submitted && $key === $q['answer']): ?>
                                    <span class="correct-highlight ms-2">(Đáp án đúng)</span>
                                <?php endif; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-lg">Nộp bài</button>
            <a href="index.php" class="btn btn-secondary btn-lg ms-2">Làm lại</a> 
            <!-- Khi bạn bấm vào link này, trình duyệt sẽ gửi một yêu cầu mới hoàn toàn (GET Request) 
             đến máy chủ để tải lại trang index.php -> chạy lại all code, reset submitted -->
        </div>
    </form>
</div>

</body>
</html>