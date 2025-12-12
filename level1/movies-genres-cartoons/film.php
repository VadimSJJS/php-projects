<?php
require_once 'config.php';

$film_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$film = null;

foreach ($films as $f) {
    if ($f['id'] == $film_id) {
        $film = $f;
        break;
    }
}

if (!$film) {
    header('Location: index.php');
    exit;
}

$similar_films = array_filter($films, function ($f) use ($film) {
    return $f['id'] != $film['id'] && $f['country'] == $film['country'];
});

$similar_films = array_slice($similar_films, 0, 4);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($film['title']); ?> - Мультфильмы</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <header>
            <div class="header-content">
                <h1><i class="fas fa-film"></i> Коллекция мультфильмов</h1>
                <a href="index.php" class="back-link">
                    <i class="fas fa-arrow-left"></i> Вернуться к списку
                </a>
            </div>
        </header>

        <main>
            <div class="film-detail">
                <div class="film-header">
                    <div class="film-poster">
                        <div class="poster-placeholder">
                            <i class="fas fa-film"></i>
                            <span><?php echo substr($film['title'], 0, 2); ?></span>
                        </div>
                    </div>

                    <div class="film-title-section">
                        <h1><?php echo htmlspecialchars($film['title']); ?></h1>
                        <div class="film-meta-detail">
                            <span class="film-rating-detail">
                                <i class="fas fa-star"></i>
                                <strong><?php echo number_format($film['rating'], 1); ?></strong>/10
                            </span>
                            <span class="film-year-detail">
                                <i class="fas fa-calendar"></i> <?php echo $film['year']; ?> год
                            </span>
                            <span class="film-country-detail">
                                <i class="fas fa-globe"></i> <?php echo $film['country']; ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="film-content">
                    <div class="film-description-full">
                        <h2><i class="fas fa-book-open"></i> Описание</h2>
                        <p><?php echo htmlspecialchars($film['full_description']); ?></p>
                    </div>

                    <div class="film-details-grid">
                        <div class="detail-card">
                            <h3><i class="fas fa-user-tie"></i> Режиссер</h3>
                            <p><?php echo htmlspecialchars($film['director']); ?></p>
                        </div>

                        <div class="detail-card">
                            <h3><i class="fas fa-users"></i> В ролях</h3>
                            <p><?php echo htmlspecialchars($film['cast']); ?></p>
                        </div>

                        <div class="detail-card">
                            <h3><i class="fas fa-calendar-alt"></i> Год выпуска</h3>
                            <p><?php echo $film['year']; ?></p>
                        </div>

                        <div class="detail-card">
                            <h3><i class="fas fa-flag"></i> Страна</h3>
                            <p><?php echo $film['country']; ?></p>
                        </div>
                    </div>

                    <div class="film-actions-detail">
                        <a href="<?php echo $film['watch_link']; ?>" target="_blank" class="watch-btn-detail">
                            <i class="fas fa-play"></i> Смотреть на Кинопоиске
                        </a>
                        <a href="index.php" class="back-btn">
                            <i class="fas fa-list"></i> К списку мультфильмов
                        </a>
                    </div>
                </div>
            </div>

            <?php if (count($similar_films) > 0): ?>
                <div class="similar-films">
                    <h2><i class="fas fa-film"></i> Похожие мультфильмы</h2>
                    <div class="similar-grid">
                        <?php foreach ($similar_films as $similar): ?>
                            <div class="similar-card">
                                <div class="similar-image">
                                    <div class="image-placeholder-small">
                                        <i class="fas fa-film"></i>
                                    </div>
                                </div>
                                <div class="similar-info">
                                    <h4><?php echo htmlspecialchars($similar['title']); ?></h4>
                                    <div class="similar-meta">
                                        <span><?php echo $similar['year']; ?></span>
                                        <span><i class="fas fa-star"></i> <?php echo number_format($similar['rating'], 1); ?></span>
                                    </div>
                                    <a href="film.php?id=<?php echo $similar['id']; ?>" class="similar-link">
                                        Подробнее <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
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