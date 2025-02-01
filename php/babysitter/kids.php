<?php

include '../common/config.php';

session_start();

$user_id = $_SESSION['babysitter_id'];

$select_children = mysqli_query($conn, "SELECT * FROM `children` WHERE babysitterId = '$user_id'") or die('query failed');

if (!isset($user_id)) {
    header('location:../common/login.php');
}

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
    <title>Kids</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>

    <?php include 'babysitter_header.php'; ?>

    <section class="babysitters">

        <div class="content">
            <div class="menu-element">
                <h3>
                    Kids you take care of
                </h3>
                <img class="image" src="../../overview/photos/child-care.jpg" alt="">

                <div class="suggested_babysitters">

                    <?php
                    if (mysqli_num_rows($select_children) > 0) {
                        ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Age</th>
                                </tr>
                            </thead>
                            <?php
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
                        echo '<p>There is no registered kid for this client yet!</p>';
                    }
                    ?>
                </table>
            </div>
        </div>
    </section>

    <script src="../../js/script.js"></script>
</body>
</html>