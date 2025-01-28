<?php

include 'createConnection.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT') {
        $lastName = $_POST['last_name'];
        $firstName = $_POST['first_name'];
        $patronymic = $_POST['patronymic'];
        $email = $_POST['email'];
        $birth = $_POST['birth'];
        $studentID = $_POST['studentID'];

        if (!isset($lastName) || !isset($firstName) || !isset($patronymic) || !isset($email) || !isset($birth) || !isset($studentID)) {
            die("Failed to edit record! Please, check your values");
        }

        $dbh->beginTransaction();

        $query = "UPDATE students 
                    SET last_name = ?, first_name = ?, patronymic = ?, email = ?, birth = ? 
                    WHERE studid = ?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($lastName, $firstName, $patronymic, $email, $birth, $studentID));

        $dbh->commit();
    } else {
        die("Bad method request!");
    }
} catch (PDOException $e) {
    echo "Database error: ". $e->getMessage();
}