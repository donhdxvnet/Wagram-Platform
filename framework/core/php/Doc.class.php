<?php

class Doc implements IDoc {
    
    private $file = null;
    private $xml = null;
    private $json = null;
    private $arr = null;
    private $files;
    
    public function __construct($file){
    	$this->file = $file;
    }

    public function load(){
      $this->xml = simplexml_load_file($this->file);
      $this->json = json_encode($this->xml);
      $this->arr = json_decode($this->json,TRUE);
    }

    public function getArray(){
    	return $this->arr;
    }

    public function scan(){
        $files = scandir($this->file);
        foreach ($files as $i => $file){
            if ($file != '.' && $file != '..'){
                $this->files[] = $file;
            }
        }
        return $this->files;
    }
}

?>
