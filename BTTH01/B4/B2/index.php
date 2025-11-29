<?php
require 'db.php';
require 'quiz.php';


$database = new Database();
$db = $database->getConnection();
$quizApp = new Quiz($db);
$message = "";

// --- XỬ LÝ UPLOAD FILE ---
if (isset($_POST['upload_btn'])) {
    if (isset($_FILES['quiz_file']) && $_FILES['quiz_file']['error'] == 0) {
        $fileTmpPath = $_FILES['quiz_file']['tmp_name'];
        $fileType = pathinfo($_FILES['quiz_file']['name'], PATHINFO_EXTENSION);

        if ($fileType == 'txt') {
            // Gọi hàm import từ class
            $quizApp->importQuestionsFromTextFile($fileTmpPath);
            $message = '<div class="alert alert-success">Upload và lưu dữ liệu thành công!</div>';
        } else {
            $message = '<div class="alert alert-danger">Vui lòng chọn file .txt</div>';
        }
    }
}

// --- LẤY DỮ LIỆU TỪ DB ĐỂ HIỂN THỊ ---
$questions = $quizApp->getQuestionsFromDB();

// --- XỬ LÝ CHẤM ĐIỂM (Giữ nguyên logic cũ) ---
$score = null;
$submitted = false;
$user_answers = [];

if (isset($_POST['submit_quiz'])) {
    $submitted = true;
    $score = 0;
    $user_answers = $_POST['answers'] ?? [];

    foreach ($questions as $index => $q) {
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
    <title>Hệ thống thi trắc nghiệm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .question-card {
            background: #effcffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            border-left: 5px solid #0d6efd;
        }
        .question-text { font-weight: bold; font-size: 1.1rem; margin-bottom: 15px; color: #0d6efd;}
        .correct-answer { background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; }
        .wrong-answer { background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; }
        .correct-highlight { color: #155724; font-weight: bold; margin-left: 10px; }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    
    <div class="card mb-5">
        <div class="card-header bg-dark text-white">Quản lý đề thi (Upload file Quiz.txt)</div>
        <div class="card-body">
            <?= $message ?>
            <form method="POST" enctype="multipart/form-data" class="d-flex gap-2">
                <input type="file" name="quiz_file" class="form-control" accept=".txt" required>
                <button type="submit" name="upload_btn" class="btn btn-warning">Upload & Cập nhật</button>
            </form>
        </div>
    </div>

    <h2 class="text-center mb-4 text-primary fw-bold">BÀI THI TRẮC NGHIỆM</h2>

    <?php if ($submitted): ?>
        <div class="alert alert-info text-center">
            <h3>Kết quả: <?= $score ?> / <?= count($questions) ?> câu đúng</h3>
            <a href="index.php" class="btn btn-secondary mt-2">Làm lại bài thi</a>
        </div>
    <?php endif; ?>

    <?php if (empty($questions)): ?>
        <div class="alert alert-warning text-center">Chưa có câu hỏi nào. Vui lòng upload file đề thi.</div>
    <?php else: ?>
        <form method="POST" action="">
            <?php foreach ($questions as $index => $q): ?>
                <div class="question-card">
                    <div class="question-text">Câu <?= $index + 1 ?>: <?= htmlspecialchars($q['question_text']) ?></div>
                    
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
                                       style="margin-top: 0;">
                                <label class="form-check-label w-100" for="q<?= $index ?>_<?= $key ?>">
                                    <?= htmlspecialchars($option_text) ?>
                                    <?php if ($submitted && $key === $q['answer']): ?>
                                        <span class="correct-highlight">(Đáp án đúng)</span>
                                    <?php endif; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="text-center mt-4 mb-5">
                <button type="submit" name="submit_quiz" class="btn btn-primary btn-lg px-5">Nộp bài</button>
            </div>
        </form>
    <?php endif; ?>
</div>

</body>
</html>