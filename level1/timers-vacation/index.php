<?php
$currentDate = date('d-m-Y');

// дата в формате: x ноября x года
function getDateStrFormat() {
    $arr = [
        1 => 'Январь',
        2 => 'Февраль',
        3 => 'Март',
        4 => 'Апрель',
        5 => 'Май',
        6 => 'Июнь',
        7 => 'Июль',
        8 => 'Август',
        9 => 'Сентябрь',
        10 => 'Октябрь',
        11 => 'Ноябрь',
        12 => 'Декабрь',
    ];
    
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        <p>Текущая дата: <?= $currentDate ?></p>
        <input type="button" value="Поменять формат на дд.мм.гггг" >
        <p>Укажите дату отпуска</p>
        <form action="" method="GET">
            <input type="date">
        </form>
    </div>
</body>

</html>