<?php

include 'createConnection.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $studentID = $_POST['studentID'];

        if (!isset($studentID)) {
            die("Failed to delete record! Please, input student ID");
        }

        $dbh->beginTransaction();

        $query1 = "DELETE FROM student_group 
                    WHERE student_id = :ID";
        $sth = $dbh->prepare($query1);
        $sth->bindParam(':ID', $studentID);
        $sth->execute();

        $query2 = "DELETE FROM students 
                    WHERE studid = :ID";
        $sth = $dbh->prepare($query2);
        $sth->bindParam(':ID', $studentID);
        $sth->execute();

        $dbh->commit();
    } else {
        die("Bad method request");
    }
} catch (PDOException $e) {
    echo "Database error: ". $e->getMessage();
}