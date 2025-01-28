<?php

include 'createConnection.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $groupID = $_POST['group_id'];

        if (!isset($groupID)) {
            die("Failed to delete record! Please, input group ID");
        }

        $dbh->beginTransaction();

        $query1 = "DELETE FROM student_group 
                    WHERE group_id = ?";
        $sth = $dbh->prepare($query1);
        $sth->execute(array($groupID));

        $query2 = "DELETE FROM groups 
                    WHERE grid = ?";
        $sth = $dbh->prepare($query2);
        $sth->execute(array($groupID));

        $dbh->commit();
    } else {
        die("Bad method request");
    }
} catch (PDOException $e) {
    echo "Database error: ". $e->getMessage();
}
