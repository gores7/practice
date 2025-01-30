<?php

include 'include.php';
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $requiredParams = ['group_name', 'group_type', 'group_id'];
        extract(checkAndPrepareParams($_REQUEST, $requiredParams));

        $update = file_get_contents('sql/updateGroup.sql');
        $sth = $dbh->prepare($update);
        $sth->execute(array($group_name, $group_type, $group_id));

        echo json_encode(['success' => true, 'msg' => 'Данные успешно обновлены']);
    } else {
        echo json_encode(['success' => false, 'msg' => 'Неверный метод запроса']);
    }
} catch (PDOException $exception) {
    echo json_encode(['success' => false, 'msg' => 'Ошибка при обновлении данных о группе']);
}