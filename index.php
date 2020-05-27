<?php
require_once './vendor/autoload.php';
use classes\Services\FileGenService;
use PhpOffice\PhpWord\TemplateProcessor;
use \Symfony\Component\Dotenv\Dotenv;
use \Doctrine\DBAL\DriverManager;
use classes\Services\GetData;

//$loader = new \Twig\Loader\FilesystemLoader('./twig/tpl');
//$twig = new \Twig\Environment($loader, [
//    'cache' => './tpl_c',
//]);
//$tr = new \App\TwigRenderer();

define('STUD_EXAM_ID', 1);
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
$userInfo = $gd->getUserInfo(STUD_EXAM_ID);
$tasks = $gd->getTaskListObject(STUD_EXAM_ID);
$q = [];
$fs = new FileGenService();
foreach ($tasks as $key => $task){

    $tasks[$key]['q_text'] = $gd->getQuestionListByTask($task['task_id'], STUD_EXAM_ID, true);
}
$fs->setUserInfo($userInfo);
$fs->setTasks($tasks);
$fs->save();
