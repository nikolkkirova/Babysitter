<?php
// Календар за детегледача
// Детегледачът трябва да може да добавя събития към календара на децата, като добавя детайли

session_start();
include '../common/config.php';   // Включваме конфигурацията за базата данни
include '../common/functions.php'; // Включваме общите функции

// Тук започва логиката на календара за детегледача
// Проверяваме дали има логнат детегледач
if (!isset($_SESSION['babysitter_id'])) {
    header('location:../common/login.php'); // Пренасочваме ако не е логнат
    exit();
}

// Вземаме информация за детегледача
$babysitter_id = $_SESSION['babysitter_id'];

// Вземаме всички деца на детегледача от базата данни
$children = getChildrenByBabysitter($babysitter_id); // Функция за вземане на деца по детегледач
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Календар на детегледача</title>
    <!-- Включваме CSS за календара -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/calendar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Включваме JS за календара -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
</head>
<body>
    <?php include 'babysitter_header.php'; ?>
    
        <h1>Calendar for children activities</h1>
       
        <div class="child-select">
            <label for="child">Choose a child:</label>
            <select id="child" name="child">
                <?php
                foreach ($children as $child) {
                    echo "<option value='{$child['id']}'>{$child['name']}</option>";
                }
                ?>
            </select>
        </div>
        
        <div id="calendar"></div>

    <script>
        $(document).ready(function() {
            // По подразбиране избираме първото дете
            var childId = $('#child').val();

            // При смяна на детето, обновяваме календара
            $('#child').change(function() {
                childId = $(this).val();
                displayEvents(childId);
            });

            // Функция за извеждане на събития
            function displayEvents(childId) {
                $.ajax({
                    url: '../common/get_events.php',  // Пътят към PHP файла, който извлича събития
                    method: 'GET',
                    data: { childId: childId },
                    success: function(response) {
                        var eventsData = JSON.parse(response);

                        // Инициализиране на календара
                        $('#calendar').fullCalendar('destroy'); // Изчистваме предишния календар
                        $('#calendar').fullCalendar({
                            header: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'month,agendaWeek,agendaDay'
                            },
                            events: eventsData, // Задаваме извлечените събития
                            editable: true, // Позволяваме редактиране на събития
                            droppable: true, // Позволяваме плъзгане и пускане на събития
                            eventClick: function(event) {
                                alert('Събитие: ' + event.title);
                                // Тук можеш да добавиш код за обработка при клик върху събитие
                            }
                        });
                    }
                });
            }

            // Първоначално зареждаме събитията за първото дете
            displayEvents(childId);
        });
    </script>
</body>
</html>