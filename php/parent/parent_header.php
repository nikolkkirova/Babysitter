<?php
if (isset($message)) { // Проверяваме дали има съобщения за показване
   // Обхождаме всички съобщения и ги показваме на страницата
   foreach ($message as $message) {
      echo '
      <div class="message">
         <span>' . $message . '</span>
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
         <!-- Лого и навигация за родителите -->
         <a href="parent.php" class="logo">Parent Navigation</a>

         <!-- Навигационно меню -->
         <nav class="navbar">
            <a href="parent.php">main</a>
            <a href="calendar.php">calendar</a>
            <a href="babysitters.php">babysitters</a>
            <a href="kids.php">kids</a>
            <a href="profile.php">personal data</a>
         </nav>

         <!-- Икони за мобилно меню и потребител -->
         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fa-solid fa-circle-user"></div>
         </div>

         <!-- Падащо меню за потребителската информация -->
         <div class="user-box">
            <p>username : <span>
                  <?php echo $_SESSION['parent_name']; ?> <!-- Показваме потребителското име -->
               </span></p>
            <p>email : <span><?php echo $_SESSION['parent_email']; ?></span></p> <!-- Показваме имейла на потребителя -->
            <a href="../common/logout.php" class="delete-btn">logout</a> <!-- Бутон за изход от профила -->
         </div>
      </div>
   </div>
</header>