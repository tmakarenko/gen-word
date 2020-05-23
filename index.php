<?php
require_once './vendor/autoload.php';
use classes\Services\FileGenService;
use \Symfony\Component\Dotenv\Dotenv;
use \Doctrine\DBAL\DriverManager;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');
$conn = array(
    'dbname' => $_ENV['DB_NAME'],
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
    'host' => $_ENV['DB_HOST'],
    'driver' => $_ENV['DB_DRIVER'],
);

$conn = DriverManager::getConnection($conn);
$qb = $conn->createQueryBuilder();
$tasks = $qb->select('*')
    ->from('srv.get_list_task(1)')
    ->execute()
    ->fetchAll(\Doctrine\DBAL\FetchMode::ASSOCIATIVE);


$fs = new FileGenService();
$fs->setTasks($tasks);
$fs->save();
//$fs->setParams('fullName', 'Кирилиця Кирилиця Ко');
//$fs->save('./docs/helloWorld.docx');
