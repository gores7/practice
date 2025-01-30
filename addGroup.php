<?php

include 'include.php';
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $requiredParams = ['group_name', 'group_type'];
        extract(checkAndPrepareParams($_REQUEST, $requiredParams));

        $insert = file_get_contents('sql/addGroup.sql');
        $sth = $dbh->prepare($insert);
        $sth->execute(array($group_name, $group_type));

        echo json_encode(['success' => true, 'msg' => 'Группа успешно добавлена']);
    } else {
        echo json_encode(['success' => false, 'msg' => 'Неверный метод запроса']);
    }
} catch (PDOException $exception) {
    echo json_encode(['success' => false, 'msg' => 'Ошибка при добавлении данных о группе']);
}
