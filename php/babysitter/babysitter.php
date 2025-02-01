<?php
// Когато детегледачка влезне в уеб - базираната среда, се пренасочва към тази страница!

include '../common/config.php'; // Включваме config.php, за да използваме връзката с базата данни
session_start(); // Стартиране на сесията, за да може да работим с данните, съхранени в сесията

$user_id = $_SESSION['babysitter_id']; // Извличаме ID-то на babysitter-а от сесията. Това ID показва кой потребител е влязъл в системата

if (!isset($user_id)) { // Проверяваме дали има зададено ID на потребителя в сесията. Ако не, потребителят не е влязъл в системата
    header('location:../common/login.php'); // Ако не е влязъл, го пренасочваме към страницата за вход
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <?php include 'babysitter_header.php'; ?> <!-- Включваме хедъра за babysitter (навигация) -->

    <section class="home">
        <div class="content">
            <div class="menu-element" onclick="location.href='parents.php'"> <!-- Създаваме елемент от менюто, който пренасочва към страницата "parents.php" -->
                <h3>Parents & Kids</h3>
                <img src="../../overview/photos/activities.jpg" alt="" class="image">
            </div>
            <div class="menu-element" onclick="location.href='profile.php'"> <!-- Втори елемент от менюто, който пренасочва към страницата "profile.php" -->
                <h3>Personal data</h3> <!-- лични данни на потребителя -->
                <img src="../../overview/photos/personal-data.jpg" alt="" class="image">
            </div>
        </div>
    </section>
    <script src="../../js/script.js"></script>
</body>
</html>