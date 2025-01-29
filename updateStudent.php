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
        $requiredParams = ['last_name', 'first_name', 'patronymic', 'email', 'birth', 'student_id'];
        $preparedParams = checkAndPrepareParams($_REQUEST, $requiredParams);
        extract($preparedParams);

        $update = file_get_contents('sql/updateStudent.sql');
        $sth = $dbh->prepare($update);
        $sth->execute(array($last_name, $first_name, $patronymic, $email, $birth, $student_id));

        echo json_encode(['success' => true, 'msg' => 'Данные успешно обновлены']);
    } else {
        echo json_encode(['success' => false, 'msg' => 'Неверный метод запроса']);
    }
} catch (PDOException $exception) {
    echo json_encode(['success' => false, 'msg' => 'Ошибка при обновлении данных о студенте']);
}