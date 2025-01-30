<?php

include 'include.php';
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $query = file_get_contents('sql/selectStudents.sql');
        $sth = $dbh->prepare($query);
        $sth->execute();

        $students = $sth->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'students' => $students]);
    } else {
        echo json_encode(['success' => false, 'msg' => 'Неверный метод запроса']);
    }
} catch (PDOException $exception) {
    echo json_encode(['success' => false, 'msg' => 'Ошибка при получении данных студентов']);
}
