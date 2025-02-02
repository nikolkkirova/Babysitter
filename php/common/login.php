<?php
include 'config.php'; // Включваме config.php, за да използваме връзката с базата данни
session_start(); // Старт на сесията, за да съхраняваме информация за потребителя по време на неговото посещение

// Проверяваме дали потребителят е натиснал бутон "submit"
if (isset($_POST['submit'])) {

   // Изчистваме стойностите на имейла и паролата от специални символи, за да предотвратим SQL инжекции
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password'])); // Хешираме паролата

   // Правим SQL заявка, за да проверим дали има потребител с този имейл и парола
   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   // Ако резултатът съдържа поне 1 ред, значи потребителят съществува
   if (mysqli_num_rows($select_users) > 0) {

      // Вземаме информацията за потребителя от резултата
      $row = mysqli_fetch_assoc($select_users);

      // Ако типът потребител е "parent", задаваме съответните сесийни променливи
      if ($row['user_type'] == 'parent') {

         $_SESSION['parent_name'] = $row['name']; // Името на родителя
         $_SESSION['parent_email'] = $row['email']; // Имейл на родителя
         $_SESSION['parent_id'] = $row['id']; // ID на родителя
         header('location:../parent/parent.php'); // Пренасочваме към страницата на родителя

      } elseif ($row['user_type'] == 'babysitter') { // Ако типът потребител е "babysitter", задаваме съответните сесийни променливи

         $_SESSION['babysitter_name'] = $row['name']; // Името на babysitter
         $_SESSION['babysitter_email'] = $row['email']; // Имейл на babysitter
         $_SESSION['babysitter_id'] = $row['id']; // ID на babysitter
         header('location:../babysitter/babysitter.php'); // Пренасочваме към страницата на babysitter
      }

   } else { // Ако потребителят не съществува, добавяме съобщение за грешка
      $message[] = 'Incorrect email or password!'; // Показваме съобщение за неправилен имейл или парола
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="../../css/style.css">
</head>

<body>

   <?php
   // Ако има съобщения (например грешки при вход), ги показваме
   if (isset($message)) {
      foreach ($message as $message) {
         echo '
      <div class="message">
         <span>' . $message . '</span>   <!-- Показваме съобщението -->
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>   <!-- Икона за премахване на съобщението -->
      </div>
      ';
      }
   }
   ?>

   <!-- Форма за вход-->
   <div class="form-container">

      <form action="" method="post">
         <h3>Let’s Get Started!</h3>
         <input type="email" name="email" placeholder="Email" required class="box"> <!-- Поле за имейл -->
         <input type="password" name="password" placeholder="Password" required class="box"> <!-- Поле за парола -->
         <input type="submit" name="submit" value="Login" class="btn"> <!-- Бутон за изпращане на формата -->
         <p>Don't have an account? <a href="register.php">Register now</a></p> <!-- Линк за регистрация, ако потребителят няма акаунт -->
      </form>

   </div>
</body>
</html>