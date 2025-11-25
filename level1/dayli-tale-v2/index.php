<?php
if (isset($_POST['age'])) {
    $age = $_POST['age'];
    $message = "";
    switch ($age) {
        case "age-0-3":
            $message = "Вы выбрали сказку для возраста от 0 до 3 лет";
            break;
        case "age-3-7":
            $message = "Вы выбрали сказку для возраста от 3 до 7 лет";
            break;
        case "age-7-12":
            $message = "Вы выбрали сказку для возраста от 7 до 12 лет";
            break;
    }
} else {

}

echo $message;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        background-color: #f5f5f5;
        line-height: 1.6;
        color: #333;
    }

    .header {
        background-color: #333;
        padding: 20px 0;
        text-align: center;
    }

    .header h1 {
        color: white;
        font-size: 2rem;
        font-weight: normal;
        margin: 0;
    }

    a {
        text-decoration: none;
        color: #C19F38;
        font-size: 18px;
    }

    a:hover {
        text-decoration: underline;
    }

    .main {
        margin-top: 50px;
        text-align: center;
    }

    .age-choice {
        display: flex;
        justify-content: center;
    }

    .age-choice label {
        margin-right: 30px;
    }

    .age-choice input {
        margin-right: 5px;
    }

    button {
        background-color: #0875E4;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 10px;
    }
</style>

<body>
    <div class="header">
        <h1>Проект "Ежедневная сказка"</h1>
        <a href="description.html">Описание проекта</a>
    </div>
    <div class="main">
        <form method="POST">
            <p><b>Выберите возраст для сказки:</b></p>
            <div class="age-choice">
                <input type="radio" value="age-0-3" name="age" />
                <label for="">От 0 до 3</label>

                <input type="radio" value="age-3-7" name="age" />
                <label for="">От 3 до 7</label>

                <input type="radio" value="age-7-12" name="age" />
                <label for="">От 7 до 12</label>
            </div>

            <button>Получить сказку</button>
        </form>
    </div>
</body>

</html>