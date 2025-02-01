<?php
// Календар за родителя
// Родителят трябва да може да вижда календар с всички събития за децата си, както и да добавя коментари към тези събития.

session_start();
include '../common/config.php';
include '../common/functions.php';
include 'parent_header.php'; 

if (!isset($_SESSION['parent_id'])) {
    header('Location: login.php');
    exit();
}

$parentId = $_SESSION['parent_id'];
$children = getChildrenByParent($parentId);
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Календар на децата</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/calendar.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
</head>

<body>
    <h1>Calendar for children activities</h1>

    <div class="child-select">
        <label for="child">Choose a child:</label>
        <select id="child" name="child">
            <?php foreach ($children as $child): ?>
                <option value="<?= $child['id']; ?>"><?= $child['name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div id="calendar"></div>

    <script>
        $(document).ready(function() {
            function loadCalendar(childId) {
                $('#calendar').fullCalendar('destroy');
                $('#calendar').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    events: function(start, end, timezone, callback) {
                        $.ajax({
                            url: 'get_events.php',
                            method: 'GET',
                            data: { childId: childId },
                            success: function(response) {
                                callback(JSON.parse(response));
                            }
                        });
                    }
                });
            }

            var firstChild = $('#child').val();
            if (firstChild) loadCalendar(firstChild);

            $('#child').change(function() {
                loadCalendar($(this).val());
            });
        });
    </script>
</body>
</html>