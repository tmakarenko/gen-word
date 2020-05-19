<?php
use PhpOffice\PhpWord\PhpWord;

class FileGenService
{
    private $phpWord;
    function __construct()
    {
        $this->phpWord = new PhpWord();
    }
}
