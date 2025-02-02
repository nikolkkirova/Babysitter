<?php
include '../common/config.php'; // Включваме конфигурационния файл, който съдържа връзката с базата данни
session_start(); // Стартираме сесията, за да можем да използваме сесийни променливи
$user_id = $_SESSION['parent_id']; // Вземаме ID на текущия потребител (родител) от сесията

// Проверяваме дали родителят е влязъл в системата, ако не – пренасочваме към страницата за вход
if (!isset($user_id)) {
    header('location:../common/login.php');
}

// Проверяваме дали е натиснат бутонът "Add" за добавяне на дете
if (isset($_POST['add_child'])) {

    // Използваме mysqli_real_escape_string, за да избегнем SQL инжекции
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);

    $child_id = uniqid("child_"); // Генерираме уникално ID за детето

    // Изпълняваме SQL заявка за добавяне на новото дете в базата данни
    mysqli_query(
        $conn,
        "INSERT INTO `children`(id, name, age, parentId) 
           VALUES('$child_id', '$name','$age','$user_id')"
    ) or die('query failed');
    $message[] = 'Kid added successfully!'; // Добавяме съобщение за успешно добавяне
    header('location:kids.php'); // Пренасочваме родителя обратно към страницата със списъка на децата

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>

    <!-- Връзка към икони от FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Връзка към външен CSS файл -->
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <!-- Включваме заглавната част за родителите -->
    <?php include 'parent_header.php'; ?>

    <section class="add-kid-form">
        <!-- Форма за добавяне на дете -->
        <form action="" method="post" enctype="multipart/form-data">
            <p id="enter_kid">Enter your kid's name and age</p>
            <!-- Поле за въвеждане на име на детето -->
            <input type="text" name="name" value="" class="box" required>
            <!-- Поле за въвеждане на възрастта на детето -->
            <input type="text" name="age" value="" class="box" required>
            <!-- Бутон за изпращане на формуляра -->
            <input type="submit" value="Add" name="add_child" class="btn">
        </form>
    </section>
     <!-- Включване на JavaScript файла за функционалности -->
    <script src="../../js/script.js"></script>
</body>
</html>