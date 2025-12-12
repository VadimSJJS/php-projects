<?php
require_once 'config.php';

$films_per_page = 10;

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$year_filter = isset($_GET['year']) ? $_GET['year'] : '';
$country_filter = isset($_GET['country']) ? $_GET['country'] : '';
$rating_filter = isset($_GET['rating']) ? $_GET['rating'] : '';

$filtered_films = $films;

if (!empty($year_filter)) {
    $filtered_films = array_filter($filtered_films, function($film) use ($year_filter) {
        return $film['year'] == $year_filter;
    });
}

if (!empty($country_filter)) {
    $filtered_films = array_filter($filtered_films, function($film) use ($country_filter) {
        return $film['country'] == $country_filter;
    });
}

if (!empty($rating_filter)) {
    $filtered_films = array_filter($filtered_films, function($film) use ($rating_filter) {
        return $film['rating'] >= floatval($rating_filter);
    });
}

$total_films = count($filtered_films);
$total_pages = ceil($total_films / $films_per_page);
$page = min($page, $total_pages);

$start_index = ($page - 1) * $films_per_page;
$current_films = array_slice($filtered_films, $start_index, $films_per_page);

$countries = getCountries($films);
$years = getYears($films);
$rating_ranges = getRatingRanges();

function truncateDescription($text, $word_limit = 20) {
    $words = explode(' ', $text);
    if (count($words) > $word_limit) {
        return implode(' ', array_slice($words, 0, $word_limit)) . '...';
    }
    return $text;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мультфильмы - Главная</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <div class="header-content">
                <h1><i class="fas fa-film"></i> Коллекция мультфильмов</h1>
                <p class="subtitle">Лучшие анимационные фильмы всех времен</p>
            </div>
        </header>

        <main>
            <div class="filters-section">
                <div class="filters-header">
                    <h2><i class="fas fa-filter"></i> Фильтры</h2>
                    <form method="GET" class="filters-form">
                        <div class="filter-group">
                            <label for="year"><i class="fas fa-calendar"></i> Год выпуска:</label>
                            <select id="year" name="year" onchange="this.form.submit()">
                                <option value="">Все годы</option>
                                <?php foreach ($years as $year): ?>
                                    <option value="<?php echo $year; ?>" <?php echo ($year_filter == $year) ? 'selected' : ''; ?>>
                                        <?php echo $year; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="country"><i class="fas fa-globe"></i> Страна:</label>
                            <select id="country" name="country" onchange="this.form.submit()">
                                <option value="">Все страны</option>
                                <?php foreach ($countries as $country): ?>
                                    <option value="<?php echo $country; ?>" <?php echo ($country_filter == $country) ? 'selected' : ''; ?>>
                                        <?php echo $country; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="rating"><i class="fas fa-star"></i> Рейтинг:</label>
                            <select id="rating" name="rating" onchange="this.form.submit()">
                                <option value="">Любой рейтинг</option>
                                <?php foreach ($rating_ranges as $label => $value): ?>
                                    <option value="<?php echo $value; ?>" <?php echo ($rating_filter == $value) ? 'selected' : ''; ?>>
                                        <?php echo $label; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <?php if ($year_filter || $country_filter || $rating_filter): ?>
                            <a href="?" class="clear-filters">
                                <i class="fas fa-times"></i> Сбросить фильтры
                            </a>
                        <?php endif; ?>
                    </form>
                </div>

                <div class="filters-info">
                    <span class="results-count">
                        Найдено мультфильмов: <strong><?php echo $total_films; ?></strong>
                    </span>
                    <?php if ($year_filter || $country_filter || $rating_filter): ?>
                        <span class="active-filters">
                            <i class="fas fa-info-circle"></i>
                            Активные фильтры:
                            <?php 
                            $active_filters = [];
                            if ($year_filter) $active_filters[] = "Год: $year_filter";
                            if ($country_filter) $active_filters[] = "Страна: $country_filter";
                            if ($rating_filter) $active_filters[] = "Рейтинг: $rating_filter+";
                            echo implode(', ', $active_filters);
                            ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="films-grid">
                <?php if (count($current_films) > 0): ?>
                    <?php foreach ($current_films as $film): ?>
                        <div class="film-card">
                            <div class="film-image">
                                <div class="image-placeholder">
                                    <i class="fas fa-film"></i>
                                    <span><?php echo substr($film['title'], 0, 2); ?></span>
                                </div>
                                <div class="film-rating">
                                    <i class="fas fa-star"></i>
                                    <span><?php echo number_format($film['rating'], 1); ?></span>
                                </div>
                            </div>
                            
                            <div class="film-info">
                                <h3 class="film-title"><?php echo htmlspecialchars($film['title']); ?></h3>
                                
                                <div class="film-meta">
                                    <span class="film-year">
                                        <i class="fas fa-calendar"></i> <?php echo $film['year']; ?>
                                    </span>
                                    <span class="film-country">
                                        <i class="fas fa-globe"></i> <?php echo $film['country']; ?>
                                    </span>
                                </div>
                                
                                <div class="film-description">
                                    <p><?php echo truncateDescription($film['description']); ?></p>
                                </div>
                                
                                <div class="film-actions">
                                    <a href="film.php?id=<?php echo $film['id']; ?>" class="details-btn">
                                        <i class="fas fa-info-circle"></i> Подробнее
                                    </a>
                                    <a href="<?php echo $film['watch_link']; ?>" target="_blank" class="watch-btn">
                                        <i class="fas fa-play"></i> Смотреть
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-results">
                        <i class="fas fa-film fa-3x"></i>
                        <h3>Мультфильмы не найдены</h3>
                        <p>Попробуйте изменить параметры фильтрации</p>
                        <a href="?" class="clear-btn">Сбросить фильтры</a>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>&year=<?php echo $year_filter; ?>&country=<?php echo $country_filter; ?>&rating=<?php echo $rating_filter; ?>" class="page-btn">
                            <i class="fas fa-chevron-left"></i> Назад
                        </a>
                    <?php endif; ?>

                    <div class="page-numbers">
                        <?php
                        $start_page = max(1, $page - 2);
                        $end_page = min($total_pages, $page + 2);
                        
                        for ($i = $start_page; $i <= $end_page; $i++):
                        ?>
                            <a href="?page=<?php echo $i; ?>&year=<?php echo $year_filter; ?>&country=<?php echo $country_filter; ?>&rating=<?php echo $rating_filter; ?>"
                               class="page-number <?php echo ($i == $page) ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </div>

                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo $page + 1; ?>&year=<?php echo $year_filter; ?>&country=<?php echo $country_filter; ?>&rating=<?php echo $rating_filter; ?>" class="page-btn">
                            Вперед <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="stats-section">
                <div class="stat-card">
                    <h3><i class="fas fa-chart-bar"></i> Статистика коллекции</h3>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-value"><?php echo count($films); ?></span>
                            <span class="stat-label">Всего мультфильмов</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value"><?php echo count($countries); ?></span>
                            <span class="stat-label">Стран</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value"><?php echo min(array_column($films, 'year')); ?>-<?php echo max(array_column($films, 'year')); ?></span>
                            <span class="stat-label">Годы выпуска</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value"><?php echo number_format(array_sum(array_column($films, 'rating')) / count($films), 1); ?></span>
                            <span class="stat-label">Средний рейтинг</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer>
            <div class="footer-content">
                <p>Коллекция мультфильмов &copy; <?php echo date('Y'); ?></p>
                <p class="footer-note">Все мультфильмы принадлежат их правообладателям</p>
            </div>
        </footer>
    </div>
</body>
</html>