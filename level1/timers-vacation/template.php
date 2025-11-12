<?php
include 'index.php';
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Таймер до отпуска</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        Проект "Таймер до отпуска"
    </header>

    <div class="description">
        <p>Проект представляет собой таймер, который отсчитывает время, оставшееся до отпуска. </p>

        <div class="description-block">
            <h2>Установка времени</h2>
            <p>При заходе на сайт должна появиться форма, с помощью которой пользователь должен ввести дату начала отпуска. Сайт должен запомнить эту информацию, а также дать возможность ее отредактировать.</p>
        </div>

        <div class="description-block">
            <h2>Работа таймера</h2>
            <p>Таймер должен вести обратный отсчет дней, часов и минут, оставшихся до отпуска. Когда таймер истечет, сайт должен пожелать пользователю хорошо провести отпуск.</p>
        </div>
    </div>

    <div class="main">
        <div class="current-date">
            Текущая дата: <?= $currentDate ?>
        </div>

        <form action="" method="POST">
            <div>
                <p>Укажите дату отпуска</p>
                <input type="date" name="vacationDate">
                <?= $errorDate; ?>
            </div>

            <button type="submit" name="calculateUntilVacation" class="format-btn">
                Посчитать сколько осталось до отпуска
            </button>

            <?php
            if (empty($errorDate)) {
                showVacationUntil();
            }
            ?>
        </form>
    </div>
</body>

</html>