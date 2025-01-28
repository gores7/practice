<?php

include 'createConnection.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $studentID = $_POST['student_id'];
        $groupID = $_POST['group_id'];
        $isMain = $_POST['is_main'];

        if (!isset($studentID) || !isset($groupID) || !isset($isMain)) {
            die("Failed to add record! Please, input all values");
        }

        if ($isMain == 1) {
            $query1 = "SELECT count(*) FROM student_group  
                        WHERE student_id = ? AND is_main = 1";
            $sth = $dbh->prepare($query1);
            $sth->execute(array($studentID));

            $count = $sth->fetchColumn();
            if ($count > 0) {
                die("Student is already in the main group!");
            }
        }

        $dbh->beginTransaction();

        $query2 = "INSERT INTO student_group (student_id, group_id, is_main) VALUES (?, ?, ?)";
        $sth = $dbh->prepare($query2);
        $sth->execute(array($studentID, $groupID, $isMain));

        $dbh->commit();
    } else {
        die("Bad method request");
    }
} catch (PDOException $e) {
    echo "Database error: ". $e->getMessage();
}


