<?php

include 'createConnection.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $lastName = $_POST['last_name'];
        $firstName = $_POST['first_name'];
        $patronymic = $_POST['patronymic'];
        $email = $_POST['email'];
        $birth = $_POST['birth'];

        if (!isset($lastName) || !isset($firstName) || !isset($patronymic) || !isset($email) || !isset($birth)) {
            die("Failed to add record! Please, input all values");
        }

        $dbh->beginTransaction();

        $query = "INSERT INTO students (last_name, first_name, patronymic, email, birth) 
                        VALUES (?, ?, ?, ?, ?)";
        $sth = $dbh->prepare($query);
        $sth->execute(array($lastName, $firstName, $patronymic, $email, $birth));

        $dbh->commit();
    } else {
        die("Bad method request");
    }
} catch (PDOException $e) {
    echo "Database error: ". $e->getMessage();
}
