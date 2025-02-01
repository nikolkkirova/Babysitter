<?php

include '../common/config.php'; // Включваме файла с конфигурацията на базата данни

session_start(); // Стартираме сесията, за да можем да използваме сесийни променливи

$user_id = $_SESSION['parent_id']; // Вземаме ID на текущия потребител (родител)

// Проверяваме дали потребителят е влязъл в системата, ако не – пренасочваме към страницата за вход
if (!isset($user_id)) {
  header('location:../common/login.php');
}

// Проверяваме дали е натиснат бутонът за обновяване на личните данни
if (isset($_POST['update_personal_data'])) {

  // Използваме mysqli_real_escape_string, за да предотвратим SQL инжекции
  $update_p_id = mysqli_real_escape_string($conn, $_POST['update_p_id']);
  $update_fullname = mysqli_real_escape_string($conn, $_POST['update_fullname']);
  $update_address = mysqli_real_escape_string($conn, $_POST['update_address']);
  $update_phone = mysqli_real_escape_string($conn, $_POST['update_phone']);
  $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
  $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

  // Изпълняваме SQL заявка за актуализиране на личните данни на родителя
  mysqli_query($conn, "UPDATE `users` 
                      SET name = '$update_name',
                          fullname = '$update_fullname',
                          address = '$update_address',
                          phone = '$update_phone',
                          email = '$update_email'
                      WHERE id = '$update_p_id'") or die('query failed');
 // Пренасочваме родителя към основната страница след актуализиране
  header('location:parent.php');

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Personal Data</title>

  <!-- Връзка към икони от FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- Връзка към външен CSS файл -->
  <link rel="stylesheet" href="../../css/style.css">
</head>

<body>

  <!-- Включваме заглавната част за родителите -->
  <?php include 'parent_header.php'; ?>

  <section class="edit-profile-form">

    <?php
    // Изпълняваме заявка за извличане на личните данни на родителя от базата
    $update_query = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'") or die('query failed');
    // Проверяваме дали има върнати резултати
    if (mysqli_num_rows($update_query) > 0) {
      // Обхождаме резултатите и попълваме формуляра със съществуващите данни
      while ($fetch_update = mysqli_fetch_assoc($update_query)) {
        ?>
        <form action="" method="post" enctype="multipart/form-data">
          <!-- Скрито поле за ID на потребителя -->
          <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
          <!-- Изображение за оформление -->
          <img class="image" src="../../assets/icons/personal-data.jpg" alt="">
          <!-- Полета за въвеждане на данни с предварително попълнена информация -->
          <input type="text" name="update_fullname" value="<?php echo $fetch_update['fullname']; ?>" class="box" required>
          <input type="text" name="update_address" value="<?php echo $fetch_update['address']; ?>" class="box" required>
          <input type="text" name="update_phone" value="<?php echo $fetch_update['phone']; ?>" class="box" required>
          <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required>
          <input type="text" name="update_email" value="<?php echo $fetch_update['email']; ?>" class="box" required>

          <!-- Бутон за изпращане на формуляра -->
          <input type="submit" value="update" name="update_personal_data" class="btn">
        </form>
        <?php
      }
    }
    ?>

  </section>

  <!-- Включване на външен JavaScript файл -->
  <script src="../../js/script.js"></script>
</body>
</html>