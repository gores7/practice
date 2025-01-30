<?php

include 'include.php';
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $requiredParams = ['group_name'];
        extract(checkAndPrepareParams($_REQUEST, $requiredParams));

        $select = file_get_contents('sql/getStudentsList.sql');
        $sth = $dbh->prepare($select);
        $sth->execute(array($group_name));

        $students = $sth->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($students);
        echo json_encode(['success' => true, 'students' => $students]);
    } else {
        echo json_encode(['success' => false, 'msg' => 'Неверный метод запроса']);
    }
} catch (PDOException $exception) {
    echo json_encode(['success' => false, 'msg' => 'Ошибка при получении списка студентов группы']);
}