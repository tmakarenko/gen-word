<?php
namespace classes\Services;

use \PhpOffice\PhpWord\TemplateProcessor;

class FileGenService
{
    private $phpWord;
    private $tplFile;

    function __construct($tplFilePath = './tpl/answers.docx')
    {
        $this->tplFile = $tplFilePath;
        $this->phpWord = new TemplateProcessor($tplFilePath);
    }

    public function setTasks($tasks = []){
        $this->phpWord->cloneBlock('block_task', 0, true, false, $tasks);
    }

    public function setTask($task = [], $q = []){
        $this->phpWord->cloneBlock('block_task', 0, true, false, [$task]);
        $this->phpWord->cloneBlock('block_q', 0, true, false, $q);

    }

    function setParams($paramName = '', $paramValue = ''){
        $this->phpWord->setValue($paramName, $paramValue);
    }
    function save(){
        $this->phpWord->saveAs('./docs/helloWorld.docx');

    }
}
