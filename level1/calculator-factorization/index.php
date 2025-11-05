<?php

// функция для нахождения простых множителей
function getPrimeFactors($number)
{
    // массив простых множителей
    $primeFactors = [];
    $primeFactor = 2;

    while ($number != 1) {
        if ($number % $primeFactor == 0) {
            $number /= $primeFactor;
            $primeFactors[] = $primeFactor;
        } else {
            $primeFactor++;
        }
    }

    return $primeFactors;
}

// Проверка простое ли число
function isPrimeNumber($number)
{
    for ($i = 2; $i < $number; $i++) {
        if ($number % $i == 0) {
            return false;
        }
    }

    return true;
}

function showSolution($result)
{
    $str = "";
    if (is_array($result)) {
        foreach ($result as $value) {
            $str .= $value . ", ";
        }
        echo substr($str, 0, strlen($str) - 2);
    } else {
        echo $result;
    }
}

$result = "";
$showSolution = false;
if (isset($_GET['prime-factors'])) {
    $showSolution = true;
    if ($_GET['prime-factors'] === '') {
        $result = "Вы не ввели число!";
    } elseif (isPrimeNumber($_GET['prime-factors'])) {
        $result = "Данное число простое";
    } else {
        $result = getPrimeFactors($_GET['prime-factors']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Разложение на простые множители</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<div class="header">
    <h1>Проект "Разложение на простые множители"</h1>
</div>



<body>
    <div class="description">
        <p>Проект представляет собой калькулятор, разлагающий числа на простые множители. </p>

        <div class="condition">
            <h2>Описание</h2>
            <p class="">Калькулятор должен представлять собой инпут, в который вводится число, и кнопку, по нажатию на которую наш сайт разлагает это число на простые множители. </p>
        </div>

    </div>

    <div class="main">
        <form action="" method="GET">
            <input type="number" placeholder="Введите число" name="prime-factors">
            <input type="submit" value="Вычислить">
        </form>
    </div>

    <?php if ($showSolution): ?>
        <div class="solution">
            <?php
            echo "Ответ - ";
            showSolution($result);
            ?>
        </div>
    <?php endif; ?>

</body>

</html>