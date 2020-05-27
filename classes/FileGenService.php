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



    public function setTask($task = []){
        $this->phpWord->cloneBlock('block_task', 0, true, false, [$task]);
    }

    public function setTasks($tasks = []){
        $this->phpWord->cloneBlock('block_task', count($tasks), true,true);
        foreach ($tasks as $key => $task) {
            $this->phpWord->setValue('txt_for_ctrl#'.($key+1), $task['txt_for_ctrl']);
            $this->phpWord->setValue('task_name#'.($key+1), $task['task_name']);
            $this->phpWord->setValue('condition_text#'.($key+1), $task['condition_text']);
            $this->phpWord->setValue('q_text#'.($key+1), $task['q_text']);
            if($task['link_on_file']) {
                $this->phpWord->setImageValue('link_on_file#' . ($key + 1), ['path' => $task['link_on_file'], 'width' => 400, 'height' => 400, 'ratio' => true]);
            }else{
                $this->phpWord->setValue('link_on_file#' . ($key + 1), $task['link_on_file']);
            }
        }

    }

    public function setQ($q = []){
        foreach ($q as $key => $question){
            $q[$key]['q_text'] = str_replace('<br />','</w:t><w:br/><w:t>',nl2br($question['q_text']));
            $q[$key]['q_text'] .= '</w:t><w:br/><w:t>';
        }
        $this->phpWord->cloneBlock('block_q', 0, true, false, $q);
    }

    public function setUserInfo($userInfo = []){
        $this->phpWord->setValue('fac', $userInfo[0]['faculty']);
        $this->phpWord->setValue('group', $userInfo[0]['group_name']);
        $this->phpWord->setValue('fullName', $userInfo[0]['full_name']);
        $this->phpWord->setValue('bilet', $userInfo[0]['object_number']);
        $this->phpWord->setValue('date', $userInfo[0]['date_start']);
    }


    function save(){
        $this->phpWord->saveAs('./docs/helloWorld1.docx');

    }
}
