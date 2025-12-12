<?php
// Вопросы теста
$questions = [
    1 => [
        'question' => 'Какой тег используется для создания заголовка первого уровня?',
        'answer' => 'h1',
        'user_answer' => '',
        'correct' => false
    ],
    2 => [
        'question' => 'Какой тег создает ссылку?',
        'answer' => 'a',
        'user_answer' => '',
        'correct' => false
    ],
    3 => [
        'question' => 'Какой тег используется для вставки изображения?',
        'answer' => 'img',
        'user_answer' => '',
        'correct' => false
    ],
    4 => [
        'question' => 'Какой тег создает ненумерованный список?',
        'answer' => 'ul',
        'user_answer' => '',
        'correct' => false
    ],
    5 => [
        'question' => 'Какой тег создает нумерованный список?',
        'answer' => 'ol',
        'user_answer' => '',
        'correct' => false
    ],
    6 => [
        'question' => 'Какой тег используется для создания таблицы?',
        'answer' => 'table',
        'user_answer' => '',
        'correct' => false
    ],
    7 => [
        'question' => 'Какой тег создает форму?',
        'answer' => 'form',
        'user_answer' => '',
        'correct' => false
    ],
    8 => [
        'question' => 'Какой тег используется для создания параграфа?',
        'answer' => 'p',
        'user_answer' => '',
        'correct' => false
    ],
    9 => [
        'question' => 'Какой тег делает текст жирным?',
        'answer' => 'strong',
        'user_answer' => '',
        'correct' => false
    ],
    10 => [
        'question' => 'Какой тег делает текст курсивом?',
        'answer' => 'em',
        'user_answer' => '',
        'correct' => false
    ]
];

$show_results = false;
$score = 0;
$total_questions = count($questions);
$percentage = 0;

// Проверка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_test'])) {
        // Проверяем ответы
        $correct_answers = 0;
        
        foreach ($questions as $id => $question_data) {
            $user_answer = trim($_POST['answer_' . $id] ?? '');
            $questions[$id]['user_answer'] = $user_answer;
            
            // Сравниваем ответы (без учета регистра)
            if (strtolower($user_answer) === strtolower($question_data['answer'])) {
                $questions[$id]['correct'] = true;
                $correct_answers++;
            } else {
                $questions[$id]['correct'] = false;
            }
        }
        
        $score = $correct_answers;
        $percentage = round(($correct_answers / $total_questions) * 100);
        $show_results = true;
    } elseif (isset($_POST['restart_test'])) {
        // Сброс теста
        $show_results = false;
        foreach ($questions as $id => $question_data) {
            $questions[$id]['user_answer'] = '';
            $questions[$id]['correct'] = false;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тест по HTML тегам</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Тест по HTML тегам</h1>
            <p class="subtitle">Проверьте свои знания HTML тегов</p>
        </header>
        
        <main>
            <?php if (!$show_results): ?>
                <form method="POST" action="">
                    <div class="test-instructions">
                        <p>Введите HTML тег для каждого вопроса. Например: &lt;тег&gt;</p>
                        <p class="note">Ответы вводятся без угловых скобок</p>
                    </div>
                    
                    <div class="questions-list">
                        <?php foreach ($questions as $id => $question_data): ?>
                            <div class="question-item">
                                <div class="question-number">Вопрос <?php echo $id; ?></div>
                                <div class="question-text"><?php echo htmlspecialchars($question_data['question']); ?></div>
                                <input type="text" 
                                       name="answer_<?php echo $id; ?>" 
                                       value="<?php echo htmlspecialchars($question_data['user_answer']); ?>"
                                       placeholder="Введите тег..."
                                       class="answer-input">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="test-controls">
                        <button type="submit" name="submit_test" class="submit-btn">
                            Проверить ответы
                        </button>
                    </div>
                </form>
            <?php else: ?>
                <div class="results-section">
                    <div class="score-card">
                        <h2>Результаты теста</h2>
                        <div class="score-display">
                            <div class="percentage-circle" data-percentage="<?php echo $percentage; ?>">
                                <span class="percentage-value"><?php echo $percentage; ?>%</span>
                            </div>
                            <div class="score-details">
                                <p>Правильных ответов: <strong><?php echo $score; ?> из <?php echo $total_questions; ?></strong></p>
                                <p class="score-message">
                                    <?php
                                    if ($percentage >= 90) {
                                        echo 'Отлично! Вы отлично знаете HTML теги!';
                                    } elseif ($percentage >= 70) {
                                        echo 'Хорошо! Вы хорошо знаете HTML теги!';
                                    } elseif ($percentage >= 50) {
                                        echo 'Удовлетворительно. Есть над чем поработать.';
                                    } else {
                                        echo 'Попробуйте еще раз! Изучите HTML теги лучше.';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="answers-review">
                        <h3>Проверка ответов:</h3>
                        <div class="answers-list">
                            <?php foreach ($questions as $id => $question_data): ?>
                                <div class="answer-item <?php echo $question_data['correct'] ? 'correct' : 'incorrect'; ?>">
                                    <div class="answer-question"><?php echo $id; ?>. <?php echo htmlspecialchars($question_data['question']); ?></div>
                                    <div class="answer-comparison">
                                        <span class="user-answer">
                                            Ваш ответ: <strong><?php echo htmlspecialchars($question_data['user_answer'] ?: '(нет ответа)'); ?></strong>
                                        </span>
                                        <span class="correct-answer">
                                            Правильный ответ: <strong><?php echo htmlspecialchars($question_data['answer']); ?></strong>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <form method="POST" action="" class="restart-form">
                        <button type="submit" name="restart_test" class="restart-btn">
                            Пройти тест заново
                        </button>
                    </form>
                </div>
            <?php endif; ?>
            
            <div class="test-info">
                <h3>Правила тестирования:</h3>
                <ul>
                    <li>Тест содержит 10 вопросов о HTML тегах</li>
                    <li>Вводите только имя тега без угловых скобок</li>
                    <li>Регистр букв не имеет значения</li>
                    <li>После завершения вы увидите свой результат и правильные ответы</li>
                </ul>
            </div>
        </main>
        
        <footer>
            <p>Тест по HTML тегам &copy; <?php echo date('Y'); ?></p>
        </footer>
    </div>
</body>
</html>