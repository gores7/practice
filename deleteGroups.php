<?php

include 'createConnection.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $groupID = $_POST['groupID'];

        if (!isset($groupID)) {
            die("Failed to delete record! Please, input group ID");
        }

        $dbh->beginTransaction();

        $query1 = "DELETE FROM student_group 
                    WHERE group_id = :ID";
        $sth = $dbh->prepare($query1);
        $sth->bindParam(':ID', $groupID);
        $sth->execute();

        $query2 = "DELETE FROM groups 
                    WHERE grid = :ID";
        $sth = $dbh->prepare($query2);
        $sth->bindParam(':ID', $groupID);
        $sth->execute();

        $dbh->commit();
    } else {
        die("Bad method request");
    }
} catch (PDOException $e) {
    echo "Database error: ". $e->getMessage();
}
