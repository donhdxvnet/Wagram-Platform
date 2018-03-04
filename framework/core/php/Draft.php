<?php

class Doc {
    
    private $xml = null 
    private $json = null;
    private $arr = null;
        
    public function load(){   
      $xml = simplexml_load_file($this->xml);
      $this>json = json_encode($xml);
      $this->arr = json_decode($this->json,TRUE);   
    }
}

class Event {
   
    private static $instance = null;
    private $events = [];

     public static function getInstance($conf){
         if (is_null(self::$_instance)){
             self::$_instance = new Db($conf);    
         } 
         return self::$_instance; 
     }
    
    public function listen($name, $callback) {
        $this->events[$name][] = $callback;
    }

    public function trigger($name, $argument = null)
    {
        foreach ($this->events[$name] as $event => $callback)
        {
            if ($argument && is_array($argument)){
                call_user_func_array($callback, $argument);
            }elseif($argument && !is_array($argument)){
                call_user_func($callback, $argument);
            }else{
                call_user_func($callback);
            }
        }
    }
}

/*

// Usage with param as array
// ==================================

Event::listen('updated', function($param1, $param2){
    echo 'Event ('. $param1 .', '. $param2 .') updated fired! <br>';
});

if($user->updated()) {
    Event::trigger('updated', ['param1', 'param2']);
}

*/

interface ILog {
  public function add($msg);
  public function save();
}

class Log implements ILog {
  private $logs = array();
  private $file = 'logs.txt';
  
  public function add($msg){
    $this->logs[] = $msg;
  }
  
  public function save(){
    $f = fopen($this->file, 'a+');
    foreach ($this->logs as $i => $log){
      fwrite($f, $log.PHP_EOL);
    }     
    $this->logs = array();       
  }
}

/*$log = new Log();
$log->add('test');
$log->save();
print_r(file_get_contents($log->file));
*/

interface IDb {
  public function query();
}

class Db implements IDb
{
    private static $instance = null;   
    private $connect = null;   
    private $select = null;
    private $conf = null;
    
  private function __construct($conf) {
    $this->conf = $conf;
  }
  
  public static function getInstance($conf){
    if (is_null(self::$_instance)){
      self::$_instance = new Db($conf);
    }
    return self::$_instance;
  }
  
  public function query($query){
      //mysql_real_escape_string
      return mysql_query($query);
  }
  
  public function connect()
  {
    $this->connect = mysql_connect($this->conf->host, $this->conf->login, $this->conf->pwd);
    if (!$this->connect){  
      die('Impossible de se connecter : ' . mysql_error());
    }
      
// Rendre la base de données foo, la base courante
    $this->select = mysql_select_db($this->conf->db, $this->connect);
    if (!$this->select){
      die ('Impossible de sélectionner la base de données : ' . mysql_error());
    }      
  }  
}

?>
