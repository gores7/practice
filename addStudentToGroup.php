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

/*
 * $is_main - наличие основной группы у студента
 * 1 - состоит в группе
 * 0 - не состоит в группе
 */

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $requiredParams = ['student_id', 'group_id', 'is_main'];
        $preparedParams = checkAndPrepareParams($_REQUEST, $requiredParams);
        extract($preparedParams);

        if ((int)$is_main === 1) {
            $select = file_get_contents('sql/checkMainGroup.sql');
            $sth = $dbh->prepare($select);
            $sth->execute(array($student_id));

            $count = $sth->fetchColumn();
            if ($count > 0) {
                echo json_encode(['success' => false, 'msg' => 'Студент уже состоит в основной группе']);
            }
        }

        $insert = file_get_contents('sql/addStudentToGroup.sql');
        $sth = $dbh->prepare($insert);
        $sth->execute(array($student_id, $group_id, $is_main));

        echo json_encode(['success' => true, 'msg' => 'Студент добавлен в группу']);
    } else {
        echo json_encode(['success' => false, 'msg' => 'Неверный метод запроса']);
    }
} catch (PDOException $exception) {
    echo json_encode(['success' => false, 'msg' => 'Ошибка при добавлении студента в группу']);
}
