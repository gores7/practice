<?php

include 'createConnection.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT') {
        $groupName = $_POST['group_name'];
        $groupType = $_POST['group_type'];

        if (!isset($groupName) || !isset($groupType)) {
            die("Failed to add record! Please, input all values!");
        }

        $dbh->beginTransaction();

        $query = "INSERT INTO groups (group_name, group_type) VALUES (?, ?)";
        $sth = $dbh->prepare($query);
        $sth->execute(array($groupName, $groupType));

        $dbh->commit();
    } else {
        die("Bad method request!");
    }
} catch (PDOException $e) {
    echo "Database error: ". $e->getMessage();
}
