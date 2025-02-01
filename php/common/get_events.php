<?php
// Включваме конфигурацията и функциите
include '../common/config.php';
include '../common/functions.php';

if (isset($_GET['childId'])) {
    $childId = $_GET['childId'];

    // Извличаме събитията за даденото дете
    $events = getChildEvents($childId);

    // Форматираме събитията за FullCalendar
    $eventsData = array();
    foreach ($events as $event) {
        $eventsData[] = array(
            'title' => $event['title'],
            'start' => $event['start_time'],
            'end' => $event['end_time'],
            'description' => $event['description'],
            'comment' => $event['comment'],
        );
    }

    // Връщаме резултата в JSON формат
    echo json_encode($eventsData);
}
?>