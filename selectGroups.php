<?php

include 'createConnection.php';
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $query = "SELECT * FROM groups";
        $sth = $dbh->prepare($query);
        $sth->execute();

        $groups = $sth->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['groups' => $groups]);

    } else {
        die("Bad method request");
    }
} catch (PDOException $e) {
    echo "Database error: ". $e->getMessage();
}
