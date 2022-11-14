<?php 

include 'IFileHandler.php';
include_once 'FileHandlerBase.php';

class JsonFileHandler extends FileHandlerBase implements IFileHandler {
    
    function __construct($directory, $filename) {
        parent::__construct($directory, $filename);
    }
    
    function readFile() {

        parent::createDirectory($this->directory);
        $path = $this->directory . "/". $this->filename . ".json";

        if(file_exists($path)) {

            $file = fopen($path,"r"); // abre el directorio con permisos de lectura
            $contents = fread($file,filesize($path));
            fclose($file);
            return json_decode($contents);

        } else 
            return false;    
    }
}