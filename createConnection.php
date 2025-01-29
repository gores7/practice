<?php

include 'database.php';

$dbh = new PDO("pgsql:host={$Hostname};dbname={$DatabaseName};port={$port}", $DatabaseUser, $DatabasePassword);
