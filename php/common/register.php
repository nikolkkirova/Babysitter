<?php
include 'config.php'; // Включваме config.php, за да използваме връзката с базата данни

if (isset($_POST['submit'])) { // Проверяваме дали потребителят е натиснал бутонът "submit" в регистрационната форма

   // Взимаме стойностите от формата и ги "изчистваме" от специални символи за сигурност за предотвратяване на SQL инжекции. 
   $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
   $address = mysqli_real_escape_string($conn, $_POST['address']);
   $phone = mysqli_real_escape_string($conn, $_POST['phone']);
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);

   // Хешираме паролите с MD5 за сигурност
   $pass = mysqli_real_escape_string($conn, md5($_POST['password'])); // Хешираме паролата
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword'])); // Хешираме потвърдената парола

   // Взимаме типа(ролята) на потребителя (parent или babysitter) и пак го изчистваме от специални символи
   $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);

   // Проверяваме дали съществува потребител със същия имейл и парола със SQL заявка
   $select_users = mysqli_query(
      $conn,
      "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'"
   ) or die('query failed'); // Ако заявката е неуспешна, изписва 'query failed'

   // Ако има намерен запис, значи потребителят вече съществува
   if (mysqli_num_rows($select_users) > 0) { // Ако в резултата има редове (потребител с такъв имейл и парола)
      $message[] = 'User already exists!'; // Добавяме съобщение, че потребителят вече съществува
   } else {
      // Проверяваме дали двете въведени пароли съвпадат
      if ($pass != $cpass) { // Ако паролите не съвпадат
         $message[] = 'Confirm password not matched!'; // Добавяме съобщение, че паролите не съвпадат
      } else {
         // Ако паролите съвпадат, генерираме уникален ID за потребителя в зависимост от типа му
         if ($user_type == "parent") { // Ако типът потребител е "parent"
            $user_id = uniqid("parent_"); // ID-то ще изглежда като "parent_..."
         } else {
            $user_id = uniqid("babysitter_"); // ID-то ще изглежда като "babysitter_..."
         }
         // Добавяме новия потребител в базата данни --> таблица `users`
         mysqli_query(
            $conn,
            "INSERT INTO `users`(id, fullname, address, phone, name, email, password, user_type) 
               VALUES('$user_id', '$fullname','$address','$phone','$name','$email','$cpass','$user_type')"
         ) or die('query failed'); // Спира изпълнението, ако заявката е грешна

         // Правим съобщение за успешно регистриране
         $message[] = 'registered successfully!';
         // Пренасочваме потребителя към login.php (страницата за вход) след успешна регистрация
         header('location:login.php');
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
   <?php
   // Ако има съобщения, ги показваме в HTML
   if (isset($message)) { // Ако има съобщения в масива $message
      foreach ($message as $message) { // За всяко съобщение
         echo '
      <div class="message">
         <span>' . $message . '</span>   <!-- Показваме съобщението -->
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>     <!-- Икона за премахване на съобщението -->
      </div>
      ';
      }
   }
   ?>

   <div class="form-container">
      <form action="" method="post"> <!-- Форма, която изпраща данни към същата страница -->
         <h3>Registration Form</h3>
         <!-- Полета за въвеждане на данни -->
         <input type="text" name="fullname" placeholder="Full name" required class="box"> <!-- Въведете име -->
         <input type="text" name="address" placeholder="Your address" required class="box"> <!-- Въведете адрес -->
         <input type="text" name="phone" placeholder="Your phone" required class="box"> <!-- Въведете телефон -->
         <input type="text" name="name" placeholder="Your username" required class="box"> <!-- Въведете потребителско име -->
         <input type="email" name="email" placeholder="Your email" required class="box"> <!-- Въведете имейл -->
         <input type="password" name="password" placeholder="Your password" required class="box"> <!-- Въведете парола -->
         <input type="password" name="cpassword" placeholder="Confirm your password" required class="box"> <!-- Потвърдете парола -->

         <!-- Избор между "parent" и "babysitter" -->
         <select name="user_type" class="box"> <!-- Падащо меню за избор на тип потребител -->
            <option value="parent">parent</option>
            <option value="babysitter">babysitter</option>
         </select>
         <input type="submit" name="submit" value="Submit" class="btn"> <!-- Бутон за изпращане на формата -->

         <!-- Линк за вход, ако вече има акаунт -->
         <p>Already have an account? <a href="login.php">Login now!</a></p> <!-- Линк към страницата за вход -->
      </form>
   </div>
</body>
</html>