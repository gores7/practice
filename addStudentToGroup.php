<?php

include 'include.php';
header('Content-Type: application/json');

/*
 * $is_main - тип группы у студента
 * 1 - основное образование
 * 0 - дополнительное образование
 */

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $requiredParams = ['student_id', 'group_id', 'is_main'];
        extract(checkAndPrepareParams($_REQUEST, $requiredParams));

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
