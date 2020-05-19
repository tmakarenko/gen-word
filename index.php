<?php
require_once './vendor/autoload.php';
require_once './FileGenService.php';

$fs = new FileGenService();

$pw = new \PhpOffice\PhpWord\PhpWord();

$section = $pw->addSection();
$section->addText(
    '"Learn from yesterday, live for today, hope for tomorrow. '
    . 'The important thing is not to stop questioning." '
    . '(Albert Einstein)'
);

$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($pw, 'Word2007');
$objWriter->save('./docs/helloWorld.docx');
