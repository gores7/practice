<?php

include 'createConnection.php';
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $groupName = $_POST['group_name'];

        if (!isset($groupName) ) {
            die("Failed to open list of students! Please, input group name");
        }

        $query = "SELECT s.first_name, s.last_name, g.group_name 
                    FROM students s
                    JOIN student_group sg ON s.studid = sg.student_id
                    JOIN groups g ON sg.group_id = g.grid
                    WHERE g.group_name = ?";

        $sth = $dbh->prepare($query);
        $sth->execute(array($groupName));

        $students = $sth->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['students' => $students]);

    } else {
        die("Bad method request");
    }
} catch (PDOException $e) {
    echo "Database error: ". $e->getMessage();
}