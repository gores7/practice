<?php

include 'include.php';
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $requiredParams = ['last_name', 'first_name', 'patronymic', 'email', 'birth'];
        extract(checkAndPrepareParams($_REQUEST, $requiredParams));

        $insert = file_get_contents('sql/addStudent.sql');
        $sth = $dbh->prepare($insert);
        $sth->execute(array($last_name, $first_name, $patronymic, $email, $birth));

        echo json_encode(['success' => true, 'msg' => 'Студент успешно добавлен']);
    } else {
        echo json_encode(['success' => false, 'msg' => 'Неверный метод запроса']);
    }
} catch (PDOException $exception) {
    echo json_encode(['success' => false, 'msg' => 'Ошибка при добавлении данных о студенте']);
}
