<?php

include 'createConnection.php';
header('Content-Type: application/json');

function checkAndPrepareParams(array $request, array $requiredParams): array
{
    $preparedParams = [];

    foreach ($requiredParams as $param) {
        if (!isset($_REQUEST[$param])) {
            echo json_encode(['success' => false, 'msg' => 'Отсутствуют необходимые параметры']);
            die();
        } else {
            $preparedParams[$param] = $request[$param];
        }
    }

    return $preparedParams;
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $requiredParams = ['group_name', 'group_type'];
        $preparedParams = checkAndPrepareParams($_REQUEST, $requiredParams);
        extract($preparedParams);

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
