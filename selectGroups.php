<?php

include 'createConnection.php';
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $select = file_get_contents('sql/selectGroups.sql');
        $sth = $dbh->prepare($select);
        $sth->execute();

        $groups = $sth->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'groups' => $groups]);
    } else {
        echo json_encode(['success' => false, 'msg' => 'Неверный метод запроса']);
    }
} catch (PDOException $exception) {
    echo json_encode(['success' => false, 'msg' => 'Ошибка при получении списка групп']);
}
