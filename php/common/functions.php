<?php
// Файл с общи функции и за родителите, и за детегледачите
include 'config.php';

// Функция за извличане на събития за дадено дете

function getChildEvents($child_id) {
    global $conn; // Взимаме връзката към базата

    $sql = "SELECT * FROM events WHERE child_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $child_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $events = [];
    while ($row = $result->fetch_assoc()) {
        $events[] = [
            "id" => $row["event_id"],
            "title" => $row["title"],
            "start" => $row["start_time"],
            "end" => $row["end_time"]
        ];
    }

    return $events;
}

// Функция за зареждане на правилните деца за даден детегледач
function getChildrenByBabysitter($babysitter_id) {
    global $conn; // Взимаме връзката с базата данни

    $sql = "SELECT * FROM children WHERE babysitterId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $babysitter_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $children = [];
    while ($row = $result->fetch_assoc()) {
        $children[] = $row;
    }

    return $children;
}

// Функция за извличане на всички деца на даден родител от базата данни
function getChildrenByParent($parentId) {
    global $conn;

    $query = "SELECT * FROM children WHERE parentId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $parentId);
    $stmt->execute();
    $result = $stmt->get_result();

    $children = [];
    while ($row = $result->fetch_assoc()) {
        $children[] = $row;
    }

    $stmt->close();
    return $children;
}

// Функция за извличане на коментари към събития
function getEventComments($eventId, $conn) {
    $sql = "SELECT comment FROM comments WHERE event_id = $eventId";
    $result = $conn->query($sql);
    return $result;
}

// Функция за добавяне на събитие
function addEvent($childId, $babysitterId, $title, $startTime, $endTime, $conn) {
    $sql = "INSERT INTO events (child_id, babysitter_id, title, start_time, end_time) 
            VALUES ('$childId', '$babysitterId', '$title', '$startTime', '$endTime')";
    if ($conn->query($sql)) {
        return $conn->insert_id;  // Връща ID на новото събитие
    }
    return false;
}

// Функция за добавяне на коментар
function addComment($eventId, $parentId, $comment, $conn) {
    $sql = "INSERT INTO comments (event_id, parent_id, comment) 
            VALUES ($eventId, '$parentId', '$comment')";
    return $conn->query($sql);
}
?>