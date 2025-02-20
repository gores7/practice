<?php

require_once __DIR__ . '/bootstrap.php';

$entityManager = getEntityManager();

if (empty($_REQUEST['act']) || empty($_REQUEST['method'])) {
    printError('Отсутствуют необходимые параметры');
}

$action = ucfirst($_REQUEST['act']);
$method = strtolower($_REQUEST['method']);

$class = 'task3\\controllers\\' . $action . 'Controller';

$controller = new $class($entityManager);

$response = $controller->$method($_REQUEST);

echo json_encode(['success' => true, 'rows' => $response]);
