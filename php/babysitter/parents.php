<?php
// Показва се списък с родителите, свързани с конкретен babysitter и дава възможност на babysitter-а да избере родител, за да види децата му
include '../common/config.php'; // Включваме config.php, за да използваме връзката с базата данни
session_start(); // Стартираме сесията, за да можем да използваме сесийни променливи

$user_id = $_SESSION['babysitter_id']; // Извлича ID-то на babysitter-а от сесията

if (!isset($user_id)) { // Проверява дали има активен сесионен ID за babysitter-а
    header('location:../common/login.php'); // Ако няма, пренасочва към страницата за вход
}

if (isset($_POST['select_parent'])) { // Проверява дали е натиснат бутонът за избор на родител
    $parentId = $_POST['parentId']; // Извлича ID-то на родителя от формата
    $_SESSION['selected_parent_id'] = $_POST['parent_id']; // Записва ID-то на избрания родител в сесията
    $_SESSION['selected_parent_name'] = $_POST['parent_name']; // Записва името на избрания родител в сесията
    header('location:parents-kids.php'); // Пренасочва към страница, където може да види децата на родителя
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
<?php include 'babysitter_header.php'; ?>

<section class="babysitters">
    <div class="content">
        <div class="menu-element">
            <h3>Connected Parents</h3>
            <img class="image" src="../../overview/photos/babysitter.jpg" alt="">

            <div class="suggested_babysitters">
                <table class="data-table"> <!-- Таблица за показване на информация за родителите -->
                    <thead>
                        <tr>
                            <th>Name</th> <!-- Колона за име на родителя -->
                            <th>Phone</th> <!-- Колона за телефон на родителя -->
                            <th>Email</th> <!-- Колона за имейл на родителя -->
                            <th>Address</th> <!-- Колона за адрес на родителя -->
                        </tr>
                    </thead>
                    <?php
                    $select_connections = mysqli_query($conn, "SELECT * FROM `children` WHERE babysitterId = '$user_id'") or die('query failed'); // Извлича всички деца, свързани с babysitter-а
                    $parentIds = array(); // Масив, който ще съхранява ID-та на родителите
                    while ($fetch_connections = mysqli_fetch_assoc($select_connections)) { // За всяко дете, свързано с babysitter-а
                        array_push($parentIds, $fetch_connections['parentId']); // Добавя ID-то на родителя в масива
                    }

                    $clients = array_unique($parentIds); // Премахва дублиращите се ID-та на родителите
                    foreach ($clients as $parentId) { // За всеки уникален родител
                        $select_parents = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$parentId'") or die('query failed'); // Извлича данните за родителя от базата данни
                        if (mysqli_num_rows($select_parents) > 0) { // Ако има намерени резултати (т.е. родителят съществува)

                            while ($fetch_parents = mysqli_fetch_assoc($select_parents)) { // За всеки родител в резултатите
                                ?>
                                <tbody>
                                    <tr class="suggested-babysitter">
                                        <td>
                                            <?php echo $fetch_parents['fullname']; ?> <!-- Показва името на родителя -->
                                        </td>
                                        <td>
                                            <?php echo $fetch_parents['phone']; ?> <!-- Показва телефона на родителя -->
                                        </td>
                                        <td>
                                            <?php echo $fetch_parents['email']; ?> <!-- Показва имейл на родителя -->
                                        </td>
                                        <td>
                                            <?php echo $fetch_parents['address']; ?> <!-- Показва адреса на родителя -->
                                        </td>
                                    </tr>
                                    <tr class="suggested-babysitter-selec"> <!-- Допълнителен ред с форма за избор на родител -->
                                        <td colspan="4">
                                            <form action="" method="post"> <!-- Формуляр за изпращане на данни към същата страница -->
                                                <input type="hidden" name="parent_id"
                                                    value="<?php echo $fetch_parents['id']; ?>"> <!-- Скрито поле с ID-то на родителя -->
                                                <input type="hidden" name="parent_name"
                                                    value="<?php echo $fetch_parents['fullname']; ?>"> <!-- Скрито поле с името на родителя -->
                                                <input type="submit" name="select_parent" value="See children"
                                                    class="option-btn"> <!-- Бутон за да се видят децата на родител -->
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                        </div>
                        <?php
                            }
                        } else {
                            echo '<p>There are no connected parents yet!</p>'; // Ако няма свързани родители, се показва съобщение
                        }
                    }
                    ?>
            </table>
        </div>
    </div>

</section>

<script src="../../js/script.js"></script>
</body>
</html>