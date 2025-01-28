<?php

include 'createConnection.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $groupName = $_POST['group_name'];
        $groupType = $_POST['group_type'];
        $groupID = $_POST['group_id'];

        if (!isset($groupName) || !isset($groupType) || !isset($groupID)) {
            die("Failed to edit record! Please, check your values!");
        }

        $dbh->beginTransaction();

        $query = "UPDATE groups SET group_name = ?, group_type = ? WHERE grid = ?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($groupName, $groupType, $groupID));

        $dbh->commit();
    } else {
        die("Bad method request!");
    }
} catch (PDOException $e) {
    echo "Database error: ". $e->getMessage();
}