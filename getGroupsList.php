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
        $requiredParams = ['first_name', 'last_name'];
        $preparedParams = checkAndPrepareParams($_REQUEST, $requiredParams);
        extract($preparedParams);

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