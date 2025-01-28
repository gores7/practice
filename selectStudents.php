<?php

include 'createConnection.php';
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $query = "SELECT * FROM students";
        $sth = $dbh->prepare($query);
        $sth->execute();

        $students = $sth->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['students' => $students]);

    } else {
        die("Bad method request");
    }
} catch (PDOException $e) {
    echo "Database error: ". $e->getMessage();
}
