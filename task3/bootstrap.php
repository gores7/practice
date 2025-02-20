<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

require_once __DIR__ . '/vendor/autoload.php';

function printError(string $message): void
{
    echo json_encode(['success' => false, 'message' => $message]);
    die();
}

function getEntityManager(): ?EntityManager
{
    $config = new Configuration();

    $metadataCache = new ArrayAdapter();
    $queryCache = new ArrayAdapter();

    $config->setMetadataCache($metadataCache);
    $config->setQueryCache($queryCache);

    $driver = new AttributeDriver([__DIR__ . '/entities']);
    $config->setMetadataDriverImpl($driver);

    $config->setProxyDir(__DIR__ . '/var/cache');
    $config->setProxyNamespace('Cache\Proxies');
    $config->setAutoGenerateProxyClasses(true);

    $dbParams = [
        'driver'   => 'pdo_pgsql',
        'dbname'   => 'practice',
        'user'     => 'postgres',
        'password' => 'P@ssw0rd',
        'host'     => 'localhost'
    ];

    $connection = DriverManager::getConnection($dbParams, $config);

    return new EntityManager($connection, $config);
}