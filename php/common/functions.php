<?php
// Файл с общи функции и за родителите, и за детегледачите
include 'config.php'; // Включваме конфигурационния файл, който съдържа връзката с базата данни

// Функция за извличане на събития за дадено дете
function getChildEvents($child_id) {
    global $conn; // Взимаме връзката към базата

    // SQL заявка за избор на всички събития за дадено дете
    $sql = "SELECT * FROM events WHERE child_id = ?";
    $stmt = $conn->prepare($sql); // Подготвяме заявката
    $stmt->bind_param("s", $child_id); // Свързваме параметъра child_id със заявката
    $stmt->execute(); // Изпълняваме заявката
    $result = $stmt->get_result(); // Взимаме резултатите, резултатът се обработва чрез get_result() функция

    $events = []; // Масив, в който ще се съхраняват събитията
    while ($row = $result->fetch_assoc()) { // Обхождаме всички резултати
        $events[] = [
            "id" => $row["event_id"], // ID на събитието
            "title" => $row["title"], // Заглавие на събитието
            "start" => $row["start_time"], // Начален час
            "end" => $row["end_time"] // Краен час
        ];
    }
    return $events; // Връщаме масива със събитията
}

// Функция за зареждане на правилните деца за даден детегледач
function getChildrenByBabysitter($babysitter_id) {
    global $conn; // Взимаме връзката към базата

    // SQL заявка за избор на всички деца, за които се грижи даден детегледач
    $sql = "SELECT * FROM children WHERE babysitterId = ?";
    $stmt = $conn->prepare($sql); // Подготвяме заявката
    $stmt->bind_param("s", $babysitter_id); // Свързваме ID - то на детегледача
    $stmt->execute(); // Изпълняваме заявката
    $result = $stmt->get_result(); // Взимаме резултатите, резултатът се обработва чрез get_result() функция
    
    $children = []; // Масив за децата на даден детегледач
    while ($row = $result->fetch_assoc()) { // Обхождаме резултатите
        $children[] = $row; // Добавяме всяко дете в масива
    }
    return $children; // Връщаме масива с деца
}

// Функция за извличане на всички деца на даден родител
function getChildrenByParent($parentId) {
    global $conn; // Взимаме връзката към базата

    // SQL заявка за избор на всички деца на даден родител
    $query = "SELECT * FROM children WHERE parentId = ?";
    $stmt = $conn->prepare($query); // Подготвяме заявката
    $stmt->bind_param("i", $parentId); // Свързваме ID - то на родителя
    $stmt->execute(); // Изпълняваме заявката
    $result = $stmt->get_result(); // Взимаме резултатите, резултатът се обработва чрез get_result() функция

    $children = []; // Масив за децата на даден родител
    while ($row = $result->fetch_assoc()) { // Обхождаме резултатите
        $children[] = $row; // Добавяме всяко дете в масива
    }

    $stmt->close(); // Затваряме заявката, така се освобождава памет, заделена от prepare() в mysqli
    return $children; // Връщаме масива с децата
}

// Функция за извличане на коментари към събития
function getEventComments($eventId, $conn) {

    // SQL заявка за извличане на коментари за дадено събитие
    $sql = "SELECT comment FROM comments WHERE event_id = $eventId";
    $result = $conn->query($sql); // Изпълняваме заявката и връщаме резултатите
    return $result; // Връщаме коментарите
}

// Функция за добавяне на събитие В БАЗАТА ДАННИ!
function addEvent($childId, $babysitterId, $title, $startTime, $endTime, $conn) {

    // SQL заявка за добавяне на ново събитие
    $sql = "INSERT INTO events (child_id, babysitter_id, title, start_time, end_time) 
            VALUES ('$childId', '$babysitterId', '$title', '$startTime', '$endTime')";
    if ($conn->query($sql)) { // Ако заявката е успешна
        return $conn->insert_id;  // Връща ID на новото събитие
    }
    return false; // Връщаме false, ако не успее да се добави
}

// Функция за добавяне на коментар към дадено събитие
function addComment($eventId, $parentId, $comment, $conn) {
    
    // SQL заявка за добавяне на коментар към събитие
    $sql = "INSERT INTO comments (event_id, parent_id, comment) 
            VALUES ($eventId, '$parentId', '$comment')";
    return $conn->query($sql); // Изпълняваме заявката и връщаме резултата (true или false)
}
?>