<?php

include 'include.php';
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $requiredParams = ['first_name', 'last_name'];
        extract(checkAndPrepareParams($_REQUEST, $requiredParams));

        $select = file_get_contents('sql/getGroupsList.sql');
        $sth = $dbh->prepare($select);
        $sth->execute(array($first_name, $last_name));

        $groups = $sth->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'groups' => $groups]);
    } else {
        echo json_encode(['success' => false, 'msg' => 'Неверный метод запроса']);
    }
} catch (PDOException $exception) {
    echo json_encode(['success' => false, 'msg' => 'Ошибка при получении списка групп для студента']);
}