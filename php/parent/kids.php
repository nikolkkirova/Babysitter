<?php
include '../common/config.php'; // Включваме конфигурационния файл, за да използваме връзката с базата данни
session_start(); // Стартираме сесията, за да можем да използваме сесийни променливи
$user_id = $_SESSION['parent_id']; // Вземаме ID на текущия потребител (родител) от сесията

// Проверяваме дали родителят е влязъл в системата, ако не – пренасочваме към страницата за вход
if (!isset($user_id)) {
    header('location:../common/login.php');
}

// Проверяваме дали е натиснат бутонът за избор на дете и пренасочваме към календара
if (isset($_POST['select_child'])) {
    $_SESSION['child_id'] = $_POST['child_id'];
    header('location:calendar.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My kid(s)</title>

    <!-- Включване на икони от FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Включване на CSS стилове -->
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>

    <!-- Включване на заглавната част за родителите -->
    <?php include 'parent_header.php'; ?>

    <section class="children">

        <div class="content">
            <div class="menu-element your-children-container">
                <h3>
                    Your registered kid
                </h3>
                <div class="registered-children">
                    <?php
                    // Изпълняваме заявка за извличане на децата на текущия родител
                    $select_child = mysqli_query($conn, "SELECT * FROM `children` WHERE parentId = '$user_id'") or die('query failed');
                    // Проверяваме дали родителят има регистрирани деца
                    if (mysqli_num_rows($select_child) > 0) {
                        ?>
                        <!-- Таблица за показване на информацията за децата -->
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Babysitter</th>
                                    <th>Calendar</th>
                                </tr>
                            </thead>
                            <?php
                            // Обхождаме резултатите и показваме информацията за всяко дете
                            while ($fetch_child = mysqli_fetch_assoc($select_child)) {
                                ?>
                                <tbody>
                                    <tr>
                                        <td><?php echo $fetch_child['name']; ?></td>
                                        <td>
                                            <?php echo $fetch_child['age']; ?>
                                        </td>
                                        <td>
                                            <?php
                                            // Проверяваме дали детето има избран детегледач
                                            $babysitter_id = $fetch_child['babysitterId'];
                                            if ($babysitter_id) {
                                                // Изпълняваме заявка за извличане на информация за детегледача
                                                $select_babysitter = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$babysitter_id'") or die('query failed');
                                                while ($fetch_babysitter = mysqli_fetch_assoc($select_babysitter)) {
                                                    echo $fetch_babysitter['fullname'];
                                                }
                                            } else {
                                                echo "Babysitter not selected yet"; // Показваме съобщение, ако няма избран детегледач
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <form action="" method="post">
                                                <input type="hidden" name="child_id" value="<?php echo $fetch_child['id']; ?>">
                                                <input type="submit" name="select_child" value="open" class="option-btn">
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                                <!-- <div class="name"><?php echo $fetch_child['name']; ?></div>
                                                <div class="age"><?php echo $fetch_child['age']; ?></div> -->
                        </div>
                        <?php
                            }
                    } else {
                        echo '<p>You have not registered kid yet!</p>'; // Ако няма регистрирани деца, показваме съобщение
                    }
                    ?>
                </table>
            </div>
        </div>
        <!-- Бутон за регистрация на ново дете -->
        <div class="add-child-container" onclick="location.href='kids.php'">
            <h3>
                Register Kid
            </h3>
            <a href="kids_add.php" class="option-btn">Add now!</a>
        </div>
        </div>
    </section>
    <!-- Включване на JavaScript файл -->
    <script src="../../js/script.js"></script>
</body>
</html>