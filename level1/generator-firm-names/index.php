<?php
require_once 'config.php';
require_once 'NameGenerator.php';

$userWords = [];
$category = 'tech';
$generatedNames = [];
$selectedCategoryName = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userInput = isset($_POST['user_words']) ? trim($_POST['user_words']) : '';
    if (!empty($userInput)) {
        $userWords = explode(',', $userInput);
        $userWords = array_map('trim', $userWords);
        $userWords = array_filter($userWords);
    }
    
    if (isset($_POST['category']) && array_key_exists($_POST['category'], $categories)) {
        $category = $_POST['category'];
    }
    
    $generator = new NameGenerator($userWords, $category);
    $generatedNames = $generator->generate(8);
    $selectedCategoryName = $generator->getCategoryName();
}

$categoriesList = NameGenerator::getCategoriesList();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Генератор названий фирм</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Генератор названий фирм</h1>
            <p class="subtitle">Создайте уникальное название для вашего бизнеса</p>
        </header>
        
        <main>
            <div class="form-section">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="user_words">Ваши слова для названия:</label>
                        <textarea id="user_words" name="user_words" rows="3" 
                                  placeholder="Введите слова через запятую (например: Альтаир, Галактика, Вектор)"><?php 
                            echo isset($_POST['user_words']) ? htmlspecialchars($_POST['user_words']) : ''; 
                        ?></textarea>
                        <div class="form-hint">Эти слова будут использоваться в генерации названий</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="category">Категория фирмы:</label>
                        <select id="category" name="category">
                            <?php foreach ($categoriesList as $key => $name): ?>
                                <option value="<?php echo $key; ?>" <?php echo ($category === $key) ? 'selected' : ''; ?>>
                                    <?php echo $name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="generate-btn">Сгенерировать названия</button>
                    </div>
                </form>
            </div>
            
            <?php if (!empty($generatedNames)): ?>
            <div class="results-section">
                <h2>Сгенерированные названия (<?php echo $selectedCategoryName; ?>):</h2>
                <div class="names-list">
                    <?php foreach ($generatedNames as $index => $name): ?>
                        <div class="name-item">
                            <div class="name-number"><?php echo $index + 1; ?>.</div>
                            <div class="name-text"><?php echo htmlspecialchars($name); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="form-hint">
                    Обновить страницу или отправить форму еще раз, чтобы получить новые варианты.
                </div>
            </div>
            <?php endif; ?>
            
            <div class="info-section">
                <h3>Как пользоваться генератором:</h3>
                <ol class="instructions">
                    <li>Введите слова через запятую, которые хотите видеть в названии (необязательно)</li>
                    <li>Выберите категорию вашего бизнеса</li>
                    <li>Нажмите кнопку "Сгенерировать названия"</li>
                    <li>Выберите понравившийся вариант из списка</li>
                </ol>
                
                <div class="stats">
                    <h4>Статистика генератора:</h4>
                    <div class="stats-grid">
                        <div class="stat">Категорий: <?php echo count($categories); ?></div>
                        <div class="stat">Шаблонов: <?php echo count($name_patterns); ?></div>
                        <div class="stat">База слов: 100+</div>
                    </div>
                </div>
            </div>
        </main>
        
        <footer>
            <p>Генератор названий фирм &copy; <?php echo date('Y'); ?></p>
            <p>Все названия генерируются случайным образом</p>
        </footer>
    </div>
</body>
</html>