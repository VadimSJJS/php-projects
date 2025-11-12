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
