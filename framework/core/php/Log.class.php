<?php 

  class Log implements ILog
  {
     private static $instance = null;
    private $logs = array();
    private $cfg;    

    public function __construct($Cfg){
      $this->Cfg = $Cfg;
      if (!is_dir($this->Cfg->dir)){
        mkdir($this->Cfg->dir, 0755, true);
      }
      $this->Cfg->path = $this->Cfg->dir.$this->Cfg->file;
    }

      public static function getSingleton($cfg){
         if (is_null(self::$instance)){
        self::$instance = new Log($cfg);
      }
      return self::$instance;
    }

    public function add($msg){
      $this->logs[] = $msg;
    }
   
    public function save()
    {
      if (count($this->logs) == 0) return false;
      $f = fopen($this->Cfg->path, 'a+');
      foreach ($this->logs as $i => $log){
        fwrite($f, $log.PHP_EOL);
      }
      $this->logs = array();
      fclose($f);
    }


  }

?>