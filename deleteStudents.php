<?php

include 'include.php';
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $requiredParams = ['student_id'];
        extract(checkAndPrepareParams($_REQUEST, $requiredParams));

        $dbh->beginTransaction();

        $deleteFromStudentGroup = file_get_contents('sql/deleteStudentFromStudentGroup.sql');
        $sth = $dbh->prepare($deleteFromStudentGroup);
        $sth->execute(array($student_id));

        $deleteFromStudents = file_get_contents('sql/deleteStudentFromStudents.sql');
        $sth = $dbh->prepare($deleteFromStudents);
        $sth->execute(array($student_id));

        $dbh->commit();

        echo json_encode(['success' => true, 'msg' => 'Данные успешно удалены']);
    } else {
        echo json_encode(['success' => false, 'msg' => 'Неверный метод запроса']);
    }
} catch (PDOException $exception) {
    echo json_encode(['success' => false, 'msg' => 'Ошибка при удалении данных о студенте']);
    $dbh->rollBack();
}