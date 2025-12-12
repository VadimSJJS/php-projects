<?php
// Инициализация переменных
$min = 1;
$max = 100;
$random_number = null;
$error = '';

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $min_input = trim($_POST['min'] ?? '');
    $max_input = trim($_POST['max'] ?? '');
    
    // Проверка заполнения полей
    if (empty($min_input) || empty($max_input)) {
        $error = 'Пожалуйста, заполните оба поля';
    } else {
        // Преобразование в числа
        $min = intval($min_input);
        $max = intval($max_input);
        
        // Валидация
        if (!is_numeric($min_input) || !is_numeric($max_input)) {
            $error = 'Пожалуйста, введите числа';
        } elseif ($min > $max) {
            $error = 'Минимальное значение должно быть меньше максимального';
        } elseif ($min < -1000000 || $max > 1000000) {
            $error = 'Числа должны быть в диапазоне от -1,000,000 до 1,000,000';
        } else {
            // Генерация случайного числа
            $random_number = rand($min, $max);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Генератор случайных чисел</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Генератор случайных чисел</h1>
            <p>Введите диапазон и получите случайное число</p>
        </div>
        
        <div class="content">
            <form method="POST" action="" class="number-form">
                <div class="input-group">
                    <div class="input-field">
                        <label for="min">От:</label>
                        <input type="number" 
                               id="min" 
                               name="min" 
                               value="<?php echo isset($_POST['min']) ? htmlspecialchars($_POST['min']) : '1'; ?>"
                               min="-1000000"
                               max="1000000"
                               required>
                    </div>
                    
                    <div class="input-field">
                        <label for="max">До:</label>
                        <input type="number" 
                               id="max" 
                               name="max" 
                               value="<?php echo isset($_POST['max']) ? htmlspecialchars($_POST['max']) : '100'; ?>"
                               min="-1000000"
                               max="1000000"
                               required>
                    </div>
                </div>
                
                <?php if ($error): ?>
                    <div class="error">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <button type="submit" class="generate-button">
                    Сгенерировать число
                </button>
            </form>
            
            <?php if ($random_number !== null): ?>
                <div class="result">
                    <h2>Результат:</h2>
                    <div class="random-number">
                        <?php echo htmlspecialchars($random_number); ?>
                    </div>
                    <p class="range-info">
                        Случайное число от <?php echo htmlspecialchars($min); ?> до <?php echo htmlspecialchars($max); ?>
                    </p>
                </div>
            <?php endif; ?>
            
            <div class="info">
                <h3>Примеры использования:</h3>
                <ul>
                    <li>Бросить кубик: от 1 до 6</li>
                    <li>Выбрать день месяца: от 1 до 31</li>
                    <li>Случайный год: от 1900 до 2024</li>
                    <li>Лотерейный билет: от 0 до 999999</li>
                </ul>
            </div>
        </div>
        
        <div class="footer">
            <p>© <?php echo date('Y'); ?> Генератор случайных чисел</p>
        </div>
    </div>
</body>
</html>