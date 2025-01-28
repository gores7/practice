<?php

include 'createConnection.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $studentID = $_POST['student_id'];

        if (!isset($studentID)) {
            die("Failed to delete record! Please, input student ID");
        }

        $dbh->beginTransaction();

        $query1 = "DELETE FROM student_group 
                    WHERE student_id = ?";
        $sth = $dbh->prepare($query1);
        $sth->execute(array($studentID));

        $query2 = "DELETE FROM students 
                    WHERE studid = ?";
        $sth = $dbh->prepare($query2);
        $sth->execute(array($studentID));

        $dbh->commit();
    } else {
        die("Bad method request");
    }
} catch (PDOException $e) {
    echo "Database error: ". $e->getMessage();
}