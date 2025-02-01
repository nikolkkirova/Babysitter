<?php
include '../common/config.php';
session_start();
$user_id = $_SESSION['parent_id'];

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
    <title>home</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>

    <?php include 'parent_header.php'; ?>

    <section class="home">

        <div class="content">
            <div class="menu-element" onclick="location.href='calendar_kids.php'">
                <h3>
                    Calendar 
                </h3>
                <img class="image" src="../../overview/photos/activities.jpg" alt="">
            </div>
            <div class="menu-element" onclick="location.href='babysitters.php'">
                <h3>
                    Babysitters
                </h3>
                <img class="image" src="../../overview/photos/babysitter.jpg" alt="">

            </div>
            <div class="menu-element" onclick="location.href='kids.php'">
                <h3>
                    Kids
                </h3>
                <img class="image" src="../../overview/photos/add-child.jpg" alt="">
            </div>
            <div class="menu-element" onclick="location.href='profile.php'">
                <h3>Personal data</h3>
                <img class="image" src="../../overview/photos/personal-data.jpg" alt="">
            </div>
        </div>
    </section>
    <script src="../../js/script.js"></script>
</body>
</html>