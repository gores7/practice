<?php

$Hostname = 'localhost';
$DatabaseName = 'practice';
$DatabaseUser = 'postgres';
$DatabasePassword = 'kuzko1234';
$port = '5432';

$dbh = new PDO("pgsql:host={$Hostname};dbname={$DatabaseName};port={$port}", $DatabaseUser, $DatabasePassword);
