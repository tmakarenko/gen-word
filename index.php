<?php
require_once './vendor/autoload.php';
use classes\Services\FileGenService;
use \Symfony\Component\Dotenv\Dotenv;
use \Doctrine\DBAL\DriverManager;
use classes\Services\GetData;

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

$gd = new GetData($conn);
$tasks = $gd->getTaskListObject(1);
$q = [];
$fs = new FileGenService();
foreach ($tasks as $key => $task){
    $q[$task['task_id']] = $gd->getQuestionListByTask($task['task_id']);
    $fs->setTask($tasks[$key], $q[$task['task_id']]);
}
$fs->save();
//$fs->setParams('fullName', 'Кирилиця Кирилиця Ко');
//$fs->save('./docs/helloWorld.docx');
