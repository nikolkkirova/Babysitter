<?php
include '../common/config.php'; // Включваме конфигурационния файл, който съдържа връзката с базата данн
session_start(); // Стартираме сесията, за да можем да използваме сесийни променливи
$user_id = $_SESSION['parent_id']; // Вземаме ID на текущия потребител (родител) от сесията

// Проверяваме дали родителят е влязъл в системата, ако не – пренасочваме към страницата за вход
if (!isset($user_id)) {
    header('location:../common/login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- Връзка към икони от FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Връзка към външен CSS файл -->
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>

    <!-- Включваме заглавната част за родителите -->
    <?php include 'parent_header.php'; ?>

    <section class="home">

        <div class="content">
            <!-- Блок за навигация към календара -->
            <div class="menu-element" onclick="location.href='calendar.php'">
                <h3>
                    Calendar 
                </h3>
                <img class="image" src="../../overview/photos/activities.jpg" alt="">
            </div>
            <!-- Блок за навигация към детегледачите -->
            <div class="menu-element" onclick="location.href='babysitters.php'">
                <h3>
                    Babysitters
                </h3>
                <img class="image" src="../../overview/photos/babysitter.jpg" alt="">

            </div>
            <!-- Блок за навигация към списъка с деца -->
            <div class="menu-element" onclick="location.href='kids.php'">
                <h3>
                    Kids
                </h3>
                <img class="image" src="../../overview/photos/add-child.jpg" alt="">
            </div>
            <!-- Блок за навигация към личните данни -->
            <div class="menu-element" onclick="location.href='profile.php'">
                <h3>Personal data</h3>
                <img class="image" src="../../overview/photos/personal-data.jpg" alt="">
            </div>
        </div>
    </section>
    <!-- Включване на външен JavaScript файл -->
    <script src="../../js/script.js"></script>
</body>
</html>