<?php
// Даден детегледач (babysitter) може да види децата на конкретен родител, с когото работи
include '../common/config.php'; // Включваме config.php, за да използваме връзката с базата данни
session_start(); // Стартираме сесията, за да можем да използваме сесийни променливи

$user_id = $_SESSION['babysitter_id']; // Вземаме ID на текущия потребител (детегледач)
// Вземаме ID и името на избрания родител от сесията
$selected_parent_id = $_SESSION['selected_parent_id'];
$selected_parent_name = $_SESSION['selected_parent_name'];

// Изпълняваме заявка за извличане на децата на избрания родител
$select_children = mysqli_query($conn, "SELECT * FROM `children` WHERE parentId = '$selected_parent_id'") or die('query failed');

// Проверяваме дали потребителят е влязъл в системата, ако не – пренасочваме към страницата за вход
if (!isset($user_id)) {
    header('location:../common/login.php');
}

// Проверяваме дали е избрано дете за управление на календара
if (isset($_POST['select_child'])) {
    $_SESSION['child_id'] = $_POST['child_id']; // Запазваме ID на избраното дете в сесията
    header('location:calendar.php'); // Пренасочваме към страницата за календара
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
    <!-- Включваме заглавната част за детегледачките -->
    <?php include 'babysitter_header.php'; ?>

    <section class="babysitters">

        <div class="content">
            <div class="menu-element">
                <h3>
                    <!-- Показваме името на родителя и неговите деца -->
                    <?php echo $selected_parent_name ?>'s Children
                </h3>
                <!-- Изображение за оформление -->
                <img class="image" src="../../overview/photos/child-care.jpg" alt="">

                <div class="suggested_babysitters">

                    <?php
                    // Проверяваме дали родителят има регистрирани деца
                    if (mysqli_num_rows($select_children) > 0) {
                        ?>
                        <!-- Таблица за показване на информацията за децата -->
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Age</th>
                                </tr>
                            </thead>
                            <?php
                            // Обхождаме върнатите резултати и ги показваме в таблицата
                            while ($fetch_children = mysqli_fetch_assoc($select_children)) {
                                ?>
                                <tbody>
                                    <tr class="suggested-babysitter">
                                        <td><?php echo $fetch_children['name']; ?></td>
                                        <td>
                                            <?php echo $fetch_children['age']; ?>
                                        </td>

                                    </tr>
                                </tbody>
                        </div>
                        <?php
                            }
                    } else {
                        // Ако няма деца, показваме съобщение
                        echo '<p>There are no registered children for this client yet!</p>';
                    }
                    ?>
                </table>
            </div>
        </div>

    </section>
    <!-- Включване на външен JavaScript файл -->
    <script src="../../js/script.js"></script>
</body>
</html>