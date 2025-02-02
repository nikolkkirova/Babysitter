<?php
// Календар за родителя
// Родителят трябва да може да вижда календар с всички събития за децата си, както и да добавя коментари към тези събития.

session_start(); // Стартираме сесията, за да имаме достъп до сесийните променливи
include '../common/config.php'; // Включваме конфигурационния файл, който съдържа връзката с базата данни
include '../common/functions.php'; // Включваме файл с допълнителни функции
include 'parent_header.php'; // Включваме заглавната част за родителите

if (!isset($_SESSION['parent_id'])) { // Проверяваме дали родителят е влязъл в системата
    // Ако не е влязъл, го пренасочваме към страницата за вход
    header('Location: login.php');
    exit();
}

$parentId = $_SESSION['parent_id']; // Вземаме ID на родителя от сесията
// Взимаме списъка с деца на родителя чрез функцията getChildrenByParent()
$children = getChildrenByParent($parentId);
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Calendar</title>
    <!-- Включваме стилове за FullCalendar -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
    <!-- Включваме външни CSS файлове -->
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/calendar.css">
    <!-- Включваме jQuery и FullCalendar библиотеките -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
</head>

<body>
    <h1>Calendar for children activities</h1>

    <!-- Падащо меню за избор на дете -->
    <div class="child-select">
        <label for="child">Choose a child:</label>
        <select id="child" name="child">
            <?php foreach ($children as $child): ?>
                <option value="<?= $child['id']; ?>"><?= $child['name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Див за показване на календара -->
    <div id="calendar"></div>

    <script>
        $(document).ready(function() {
            function loadCalendar(childId) {
                // Унищожаваме предишния календар (ако има такъв) и зареждаме нов с данните за избраното дете
                $('#calendar').fullCalendar('destroy');
                $('#calendar').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    events: function(start, end, timezone, callback) {
                        // Изпращаме AJAX заявка за зареждане на събитията от get_events.php
                        $.ajax({
                            url: 'get_events.php',
                            method: 'GET',
                            data: { childId: childId },
                            success: function(response) {
                                // Парсираме върнатите събития и ги подаваме на календара
                                callback(JSON.parse(response));
                            }
                        });
                    }
                });
            }

            // Зареждаме календара с първото дете от списъка (ако има такова
            var firstChild = $('#child').val();
            if (firstChild) loadCalendar(firstChild);

            // При промяна на избраното дете се презарежда календарът
            $('#child').change(function() {
                loadCalendar($(this).val());
            });
        });
    </script>
</body>
</html>