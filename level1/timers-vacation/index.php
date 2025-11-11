<?php
session_start();

// Текущая дата
$currentDate = date('d.m.Y H:i:s');
$errorDate = "";

function showVacationUntil()
{
    global $currentDate, $vacationDate;
    
    $diff = strtotime($vacationDate) - strtotime($currentDate);
    
    $days = floor($diff / (60 * 60 * 24));
    $hours = floor(($diff % (60 * 60 * 24)) / (60 * 60));
    $minutes = floor(($diff % (60 * 60)) / 60);

    echo "<div class=\"untilVacation\">";
    echo "<p>Текущая дата: " . $currentDate . "</p>";
    echo "<p>Дата отпуска: " . $vacationDate . "</p>";
    // Если отпуск настал
    if ($days == 0 && $hours == 0 && $minutes == 0) {
        echo "<p>Отпуск наступил, хорошо провести отпуск!</p>";
    } else {
        echo "<p>Осталось до отпуска: "  . $days . " дней, " . $hours . " часов, " . $minutes . " минут" . " </p>";
    }
    echo "</div>";
}

// проверка чтобы дата отспуска была больше чем текущая дата
function isVacationDateValid($currentDate, $vacationDate)
{
    $currentTimestamp = strtotime(str_replace('.', '-', $currentDate));
    $vacationTimestamp = strtotime($vacationDate);
    return $vacationTimestamp >= $currentTimestamp;
}

// Дата отпуска
if (isset($_POST['calculateUntilVacation'])) {
    if (empty($_POST['vacationDate'])) {
        $errorDate = "Вы не указали дату";
    } else {
        $vacationDate = date("d.n.Y H:i:s", strtotime($_POST['vacationDate']));
        if (!isVacationDateValid($currentDate, $vacationDate)) {
            $errorDate = "Вы указали дату отпуска: " . $vacationDate . ". Но нужно указывать дату отпуска которая не меньше текущей даты";
        } else {
            $_SESSION['vacationDate'] = $vacationDate;
            $errorDate = "";
        }
    }
}

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