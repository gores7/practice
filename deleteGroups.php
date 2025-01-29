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
        $requiredParams = ['group_id'];
        $preparedParams = checkAndPrepareParams($_REQUEST, $requiredParams);
        extract($preparedParams);

        $dbh->beginTransaction();

        $deleteFromStudentGroup = file_get_contents('sql/deleteGroupFromStudentGroup.sql');
        $sth = $dbh->prepare($deleteFromStudentGroup);
        $sth->execute(array($group_id));

        $deleteFromGroups = file_get_contents('sql/deleteGroupFromGroups.sql');
        $sth = $dbh->prepare($deleteFromGroups);
        $sth->execute(array($group_id));

        $dbh->commit();

        echo json_encode(['success' => true, 'msg' => 'Данные успешно удалены']);
    } else {
        echo json_encode(['success' => false, 'msg' => 'Неверные метод запроса']);
    }
} catch (PDOException $exception) {
    echo json_encode(['success' => false, 'msg' => 'Ошибка при удалении данных о группе']);
    $dbh->rollBack();
}
