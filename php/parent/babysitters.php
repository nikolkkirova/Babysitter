<?php
include '../common/config.php'; // Включваме конфигурационния файл, за да използваме връзката с базата данни
session_start(); // Стартираме сесията, за да можем да използваме сесийни променливи

$user_id = $_SESSION['parent_id']; // Вземаме ID на текущия потребител (родител) от сесията

// Проверяваме дали родителят е влязъл в системата, ако не – пренасочваме към страницата за вход
if (!isset($user_id)) {
    header('location:../common/login.php');
}

// Проверяваме дали е натиснат бутонът "select" за избор на детегледач
if (isset($_POST['select_babysitter'])) {
    // Вземаме ID на избрания детегледач и предпазваме от SQL инжекции
    $babysitter_id = mysqli_real_escape_string($conn, $_POST['babysitter_id']);

    // Обновяваме записа в базата данни, за да присвоим избрания детегледач на всички деца на родителя
    mysqli_query($conn, "UPDATE `children` SET babysitterId = '$babysitter_id' WHERE parentId = '$user_id'") or die('query failed');
    $message[] = 'Babysitter successfully selected'; // Добавяме съобщение за успешно избран детегледач
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suggested Babysitters</title>

    <!-- Връзка към икони от FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Връзка към външен CSS файл -->
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>

    <!-- Включваме заглавната част за родителите -->
    <?php include 'parent_header.php'; ?>

    <section class="babysitters">

        <div class="content">
            <div class="menu-element">
                <h3>
                    Suggested Babysitters
                </h3>
                <img class="image" src="../../assets/icons/babysitter.jpg" alt="">

                <div class="suggested_babysitters">

                    <?php
                    // Изпълняваме заявка за извличане на всички потребители с тип "babysitter"
                    $select_babysitter = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'babysitter'") or die('query failed');
                    if (mysqli_num_rows($select_babysitter) > 0) { // Проверяваме дали има налични детегледачи в базата данни
                        ?>
                        <!-- Таблица за показване на наличните детегледачи -->
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <?php
                            // Обхождаме резултатите и показваме информацията за всеки детегледач
                            while ($fetch_babysitter = mysqli_fetch_assoc($select_babysitter)) {
                                ?>
                                <tbody>
                                    <tr class="suggested-babysitter">
                                        <td><?php echo $fetch_babysitter['fullname']; ?></td>
                                        <td>
                                            <?php echo $fetch_babysitter['phone']; ?>
                                        </td>
                                        <td>
                                            <?php echo $fetch_babysitter['email']; ?>
                                        </td>
                                        <td>
                                            <?php echo $fetch_babysitter['address']; ?>
                                        </td>
                                    </tr>
                                    <tr class="suggested-babysitter-selec">
                                        <td colspan="4">
                                            <!-- Форма за избор на детегледач -->
                                            <form action="" method="post">
                                                <input type="hidden" name="babysitter_id"
                                                    value="<?php echo $fetch_babysitter['id']; ?>">
                                                <input type="submit" name="select_babysitter" value="select" class="option-btn">
                                            </form>
                                        </td>
                                    </tr>

                                </tbody>
                        </div>
                        <?php
                            }
                    } else {
                        echo '<p>There are no registered babysitters yet!</p>'; // Ако няма регистрирани детегледачи, показваме съобщение
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