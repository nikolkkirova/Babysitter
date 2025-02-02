<?php
// Проверяваме дали има съобщения за показване
if (isset($message)) {
    // Обхождаме всички съобщения и ги извеждаме на страницата
    foreach ($message as $message) {
        echo '
        <div class="message">
            <span>' . $message .'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>

<!-- Хедър секцията на страницата -->
<header class="header">
    <div class="header-2">
        <div class="flex">
            <!-- Лого и навигация за детегледачи -->
            <a href="babysitter.php" class="logo">Babysitter Navigation</a>

            <!-- Навигационно меню -->
            <nav class="navbar">
                <a href="babysitter.php">main</a>
                <a href="calendar.php">calendar</a>
                <a href="parents.php">parents</a>
                <a href="kids.php">kids</a>
                <a href="profile.php">personal data</a>
            </nav>
            <!-- Икони за мобилно меню и профил на потребителя -->
            <div class="icons">
                <div id="menu-btn" class="fas fa-bars"></div> <!-- Бутон за мобилно меню -->
                <div id="user-btn" class="fa-solid fa-circle-user"></div> <!-- Бутон за отваряне на потребителското меню -->
            </div>

            <!-- Падащо меню за потребителската информация -->
            <div class="user-box">
                <p>username: <span>
                    <?php echo $_SESSION['babysitter_name']; ?> <!-- Показване на потребителското име -->
                </span></p>
                <p>email: <span> <?php echo $_SESSION['babysitter_email']; ?> </span></p> <!-- Показване на имейла -->
                <a href="../common/logout.php" class="delete-btn">logout</a> <!-- Бутон за изход от профила -->
            </div>
        </div>
    </div>
</header>