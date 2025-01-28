<?php

include 'createConnection.php';
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];

        if (!isset($firstName) || !isset($lastName)) {
            die("Failed to open list of groups! Please, input student's name");
        }

        $query = "SELECT g.group_name, g.group_type, sg.is_main
                    FROM groups g
                    JOIN student_group sg ON g.grid = sg.group_id 
                    JOIN students s ON sg.student_id = s.studid
                    WHERE s.first_name = ? AND s.last_name = ?";
        $sth = $dbh->prepare($query);

        $sth->execute(array($firstName, $lastName));

        $groups = $sth->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['groups' => $groups]);

    } else {
        die("Bad method request");
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}