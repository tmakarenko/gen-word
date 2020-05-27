<?php


namespace App;


class TwigRenderer
{
    private $twig;
    private $template;

    public function __construct()
    {
        global $twig;
        $this->template = $twig->load('index.html');
        $this->template->render();
    }


    public function setTask(){

    }

}